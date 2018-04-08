<?php

namespace Modules\User;

class Controller extends \Phalcon\Mvc\Controller
{
    public function infoAction()
    {
        return array(
            'username' => 'test'
        );
    }
}
