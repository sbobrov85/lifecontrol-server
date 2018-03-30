<?php
namespace Modules\User;

use
    Includes\ModuleInstall,
    Modules\User\Controller as UserController,
    Phalcon\Mvc\Micro\Collection;

class Install extends ModuleInstall
{
    /**
     * {@inheritdoc}
     */
    public static function getModuleInfo(): array
    {
        return [
            'name' => 'user',
            'version' => 100
        ];
    }

    //--------------------------------------------------------------------------

    /**
     * {@inheritdoc}
     */
    public static function unregister(): bool
    {
        //todo: write code
        return true;
    }

    //--------------------------------------------------------------------------

    /**
     * {@inheritdoc}
     */
    public static function routes(): Collection
    {
        $collection = new Collection();

        $collection->setHandler('\Modules\User\Controller', true);
        $collection->setPrefix('/user');
        $collection->get('/info', 'infoAction');

        return $collection;
    }

    //--------------------------------------------------------------------------

    /**
     * {@inheritdoc}
     */
    public static function listeners(): array
    {
        return [
            'micro' => new class {
                function beforeExecuteRoute() {
                    UserController::checkAuth();
                }
            }
        ];
    }
}