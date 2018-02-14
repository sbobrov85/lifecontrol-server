<?php

namespace Includes;

/**
 * Interface ModuleInstall.
 *
 * Common interface for core and 3rd party modules.
 * See modules/README.md for details.
 */
interface ModuleInstall {
    /**
     * Actions for module register into application.
     *
     * @return boolean true, if success, false otherwise.
     */
    public static function register(): boolean;

    //--------------------------------------------------------------------------

    /**
     * Actions for module unregister from application.
     *
     * @return boolean true, if success, false otherwise.
     */
    public static function unregister(): boolean;

    //--------------------------------------------------------------------------

    /**
     * Getting a collection of routers.
     *
     * @return \Phalcon\Mvc\Micro\Collection rotes collections.
     */
    public static function routes(): \Phalcon\Mvc\Micro\Collection;

    //--------------------------------------------------------------------------

    /**
     * Getting a collection of listeners.
     *
     * @return array pairs 'Component' => listener instance.
     */
    public static function listeners(): array;
}
