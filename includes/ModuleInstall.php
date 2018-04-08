<?php

namespace Includes;

use
    \Phalcon\Di,
    \Phalcon\Db\Adapter\Pdo as AdapterPdo,
    \Models\Module;

/**
 * Class ModuleInstall.
 *
 * Common class for core and 3rd party modules.
 * See modules/README.md for details.
 */
abstract class ModuleInstall {
    /**
     * Contains dependency injector instance.
     */
    private $di = null;

    /**
     * Contains current module full namespace.
     */
    private $moduleNamespace = null;


    /**
     * Contains current module base dir name.
     */
    private $moduleBaseDir = null;

    //--------------------------------------------------------------------------

    /**
     * Class constructor.
     *
     * @param \Phalcon\Di $di current di.
     */
    final public function __construct(Di $di) {
        $this->di = $di;

        $moduleReflectionClass = (new \ReflectionClass(get_class($this)));

        $this->moduleNamespace = $moduleReflectionClass->getNamespaceName();
        $this->moduleBaseDir = dirname($moduleReflectionClass->getFileName());

        $this->registerDefaultNamespaces();
    }

    //--------------------------------------------------------------------------

    /**
     * Register default modules namespaces, like models, etc.
     */
    protected function registerDefaultNamespaces()
    {
        $loader = $this->di->get('loader');
        $loader->registerNamespaces([
            $this->moduleNamespace => $this->moduleBaseDir,
            $this->moduleNamespace . '\Models' => $this->moduleBaseDir
                . '/models',
            $this->moduleNamespace . '\Models\Base' => $this->moduleBaseDir
                . '/models/base',
            $this->moduleNamespace . '\Plugins' => $this->moduleBaseDir
                . '/plugins',
        ], true);
        $loader->register();
    }

    //--------------------------------------------------------------------------

    /**
     * Get database connection.
     *
     * @return \Phalcon\Db\Adapter\Pdo database connection instance.
     */
    final protected function getDb(): \Phalcon\Db\Adapter\Pdo
    {
        return $this->di->get('db');
    }

    //--------------------------------------------------------------------------

    /**
     * Get current logger from di.
     */
    final protected function getLogger(): \Phalcon\Logger\Adapter
    {
        return $this->di->get('logger');
    }

    //--------------------------------------------------------------------------

    /**
     * Get module info.
     *
     * @return array key => value pairs:
     *                  name => module name in lower case,
     *                  version => version (number, w/o symbols)
     */
    abstract public static function getModuleInfo(): array;

    //--------------------------------------------------------------------------

    /**
     * Check installation status for current module.
     *
     * @param \Phalcon\Db\Adapter\Pdo $db current db connection.
     *
     * @return bool true, if module installed, false otherwise.
     */
    public static function isInstalled(\Phalcon\Db\Adapter\Pdo $db): bool {
        $info = static::getModuleInfo();

        $result = false;

        $moduleName = $info['name'] ?? null;
        $moduleVersion = $info['version'] ?? null;

        if ($moduleName && $moduleVersion) {
            $module = Module::findFirstByName($moduleName);
            if ($module) {
                $result = true;
            }
        }

        return $result;
    }

    //--------------------------------------------------------------------------

    /**
     * Actions for module register into application.
     *
     * @return bool true, if success, false otherwise.
     */
    final public function register(): bool
    {
        $result = false;

        if (!static::isInstalled($this->getDb())) {
            $module = new Module(static::getModuleInfo());

            $result = $module->save($info);
            if ($result) {
                $result = $this->createTables();
            }
        }

        return $result;
    }

    //--------------------------------------------------------------------------

    /**
     * Creating module tables into db.
     *
     * @return bool true - if success, false - otherwise.
     */
    final protected function createTables(): bool
    {
        $reflect = new \ReflectionClass($this);
        $path = dirname($reflect->getFileName()) . DIRECTORY_SEPARATOR
            . 'models' . DIRECTORY_SEPARATOR
            . '*.php';

        $models = array_map(function ($filename) {
            return basename($filename, '.php');
        }, glob($path));

        return $this->doCreateTables($models);
    }

    //--------------------------------------------------------------------------

    /**
     * Create tables from models list.
     * @param array $models models list from module folder models.
     * @return bool true, if no errors, false otherwise.
     */
    private function doCreateTables($models): bool
    {
        // tables of module do not exists, but it's right
        $result = true;
        $db = $this->getDb();
        $logger = $this->getLogger();

        try {
            // trying create tables from models info
            foreach ($models as $model) {
                $className = '\\' . $this->moduleNamespace
                    . '\\Models\\' . $model;
                $instance = new $className();

                $tableName = $instance->getSource();

                $logger->debug('Create table: ' . $tableName);
                $db->createTable(
                    $tableName,
                    null,
                    [
                        'columns' => $className::getTableColumns()
                    ]
                );
            }
        } catch (Exception $e) { // skip create tables on error...
            $this->getLogger()->error(
                "Error on create tables:\n"
                    . "classname: $className\n"
                    . "message:\n" . $e->getMessage()
            );
            $result = false;
        }

        return $result;
    }

    //--------------------------------------------------------------------------

    /**
     * Actions for module unregister from application.
     *
     * @return bool true, if success, false otherwise.
     */
    abstract public static function unregister(): bool;

    //--------------------------------------------------------------------------

    /**
     * Getting a collection of routers.
     *
     * @return \Phalcon\Mvc\Micro\Collection rotes collections.
     */
    abstract public static function routes(): \Phalcon\Mvc\Micro\Collection;

    //--------------------------------------------------------------------------

    /**
     * Getting a collection of listeners.
     *
     * @return array pairs 'Module' => listener instance.
     */
    abstract public function listeners(): array;
}
