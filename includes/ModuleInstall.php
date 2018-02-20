<?php

namespace Includes;

use
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
     * Contains instance of current database connection.
     */
    private $db = null;

    //--------------------------------------------------------------------------

    /**
     * Class constructor.
     *
     * @param \Phalcon\Db\Adapter\Pdo $db current database connection.
     */
    final public function __construct(AdapterPdo $db) {
        $this->setDb($db);
    }

    //--------------------------------------------------------------------------

    /**
     * Set current database connection.
     *
     * @param \Phalcon\Db\Adapter\Pdo $db database connection.
     */
    final public function setDb(AdapterPdo $db)
    {
        $this->db = $db;
    }

    //--------------------------------------------------------------------------

    /**
     * Get database connection.
     *
     * @return \Phalcon\Db\Adapter\Pdo database connection instance.
     */
    final public function getDb(): \Phalcon\Db\Adapter\Pdo
    {
        return $this->db;
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
    public static function isInstalled(AdapterPdo $db): bool {
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
    abstract public static function listeners(): array;
}
