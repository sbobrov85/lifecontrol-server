<?php

namespace Helpers;

/**
 * Class Module.
 *
 * Contains functions for modules control, e.c. register, unregister and others.
 */
final class Module {
    /**
     * Scaning modules folder and building full class names.
     *
     * @return array list of full module class names.
     */
    protected  static function scanModules(): array
    {
        $modules = array();

        $moduleFolders = glob(
            PROJECT_ROOT . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . '*',
            GLOB_ONLYDIR
        );

        $modules = array_map(function($moduleFolder) {
            return basename('Modules\\' . $moduleFolder . '\Install');
        }, $moduleFolders);

        return $modules;
    }

    //--------------------------------------------------------------------------

    /**
     * Scaning modules and collect routes to application.
     */
    public static function collectRoutes(\Phalcon\Mvc\Micro &$app)
    {
        $modules = self::scanModules();
        foreach ($modules as $module) {
            $routes = $moduleClassName::routes();
            if (!empty($routes)) {
                $app->mount($routes);
            }
        }
    }
}