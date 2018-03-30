<?php
namespace Modules\User;

class Controller
{
    public function infoAction()
    {
        return array(
            'username' => 'test'
        );
    }

    //--------------------------------------------------------------------------

    public static function checkAuth(): bool
    {
        return true; //TODO: write code
    }
}