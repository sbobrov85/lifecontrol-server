<?php
namespace Modules\User;

use Includes\ModuleInstall;
use Modules\User\Controller as UserController;
use Phalcon\Mvc\Micro\Collection;
use Modules\User\Plugins\Security as SecurityPlugin;

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
        $collection->post('/info', 'infoAction');

        return $collection;
    }

    //--------------------------------------------------------------------------

    /**
     * {@inheritdoc}
     */
    public function listeners(): array
    {
        return [
            'micro' => new SecurityPlugin()
        ];
    }
}
