<?php

namespace Modules\User\Plugins;

class Security extends \Phalcon\Mvc\User\Plugin
{
    /**
     * Determining the level of access to the application.
     * Require login and password variables in post request.
     */
    public function beforeExecuteRoute(
        \Phalcon\Events\Event $event,
        \Phalcon\Mvc\Micro $dispatcher
    ) {
        $di = $dispatcher->getDi();
        $logger = $di->get('logger');

        $login = $di->getRequest()->getPost('login');
        $password = $di->getRequest()->getPost('password');

        $logger->debug('Check access for: ' . $login);

        $auth = $this->session->get('auth');

        if (!$auth) {
            $auth = $this->checkAuth($login, $password);
            $logger->info('Access granted as ' . ($auth ? 'user' : 'guest'));
            $this->session->set('auth', $auth);
        }

        return true;
    }

    //--------------------------------------------------------------------------

    /**
     * Check auth by login and password.
     */
    protected function checkAuth($login, $password)
    {
        $auth = \Modules\User\Models\User::ROLE_GUEST;

        $user = \Modules\User\Models\User::findFirstByLogin($login);

        if ($user && $this->security->checkHash($password, $user->password)) {
            $auth = \Modules\User\Models\User::ROLE_USER;
        }

        return $auth;
    }
}
