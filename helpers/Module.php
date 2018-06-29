<?php

namespace Helpers;

use \Phalcon\Mvc\Micro;
use \Phalcon\Events\Manager as EventsManager;
use \Phalcon\Logger\Adapter as LoggerAdapter;

/**
 * Class Module.
 *
 * Contains functions for modules control, e.c. register, unregister and others.
 */
final class Module
{
    /**
     * Scaning modules folder and building full class names.
     *
     * @return array list of full module class names.
     */
    protected static function scanModules(): array
    {
        $modules = array();

        $moduleFolders = glob(
            PROJECT_ROOT . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . '*',
            GLOB_ONLYDIR
        );

        $modules = array_map(function($moduleFolder) {
            return 'Modules\\' . basename($moduleFolder . '\Install');
        }, $moduleFolders);

        return $modules;
    }

    //--------------------------------------------------------------------------

    /**
     * Register all modules.
     * Scan add mount routes, attach events, register new modules.
     *
     * @param \Phalcon\Mvc\Micro $app current application.
     * @param \Phalcon\Logger\Adapter $logger current logger.
     */
    public static function register(Micro &$app, LoggerAdapter $logger)
    {
        $modules = self::scanModules();

        $logger->debug('Finded modules count: ' . count($modules));

        foreach ($modules as $moduleClassName) {
            $logger->debug('Prepare ' . $moduleClassName);

            $db = $app->getDi()->get('db');
            if (!$moduleClassName::isInstalled($db)) {
                $logger->warning("Module $moduleClassName not installed!");
                $logger->info('Attempt register');

                if (!(new $moduleClassName($app->getDi()))->register()) {
                    $logger->error('Error on register! Skipped.');
                    continue;
                } else {
                    $logger->info("Module installed");
                }
            }

            $logger->debug('Collect routes');
            self::collectRoutes($app, $moduleClassName);

            $logger->debug('Attach events');
            $eventsManager = self::collectListeners($app, $moduleClassName);
            $app->setEventsManager($eventsManager);

            $logger->debug('Finished');
        }

    }

    //--------------------------------------------------------------------------

    /**
     * Collect routes to application.
     *
     * @param \Phalcon\Mvc\Micro $app current application.
     * @param string $moduleClassName full module class name.
     */
    private static function collectRoutes(Micro &$app, string $moduleClassName)
    {
        $routes = $moduleClassName::routes();
        if (!empty($routes)) {
            $app->mount($routes);
        }
    }

    //--------------------------------------------------------------------------

    /**
     * Collect events listeners to events manager.
     *
     * @param \Phalcon\Mvc\Micro $app current application.
     * @param string $moduleClassName full module class name.
     *
     * @return \Phalcon\Events\Manager manager instance.
     */
    private static function collectListeners(
        Micro $app,
        string $moduleClassName
    ) : \Phalcon\Events\Manager {
        $eventsManager = new EventsManager();

        $listeners = (new $moduleClassName($app->getDi()))->listeners();
        if (is_array($listeners)) {
            foreach ($listeners as $component => $listener) {
                $eventsManager->attach($component, $listener);
            }
        }

        return $eventsManager;
    }
}
