<?php

namespace Includes;

/**
 * Class ModuleInstall.
 *
 * Common class for core and 3rd party modules.
 * See modules/README.md for details.
 */
abstract class ModuleInstall {
    /**
     * Get module prefix.
     *
     * @return string module prefix with _ symbol.
     */
    // abstract public static function getModulePrefix():string;

    //--------------------------------------------------------------------------

    /**
     * Actions for module register into application.
     *
     * @return bool true, if success, false otherwise.
     */
    abstract public static function register(): bool;

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
