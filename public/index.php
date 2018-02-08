<?php
//define path constants
define('PROJECT_ROOT', __DIR__ . DIRECTORY_SEPARATOR . '..');
define('CONFIG_DIR', PROJECT_ROOT . DIRECTORY_SEPARATOR . 'config');

try {
    require_once(CONFIG_DIR . DIRECTORY_SEPARATOR . 'di.php');

    $app = new \Phalcon\Mvc\Micro();

    $app->setDI($di);

    // enable logging and share it
    $loggerConfig = $di->get('config')->get('logger');
    $logger = \Phalcon\Logger\Factory::load($loggerConfig);
    $di->set('logger', $logger);
    $logger->debug('Logger init success');

    $app->handle();
} catch (\Exception $e) { // log any other exceptions...
    if (isset($logger)) {
        $logger->critical("Application interrupt with\n $e");
    } else {
        echo "WARNING! Logger not initilized!\n$e\n";
    }
}