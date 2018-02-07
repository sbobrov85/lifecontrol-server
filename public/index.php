<?php
//define path constants
define('PROJECT_ROOT', __DIR__ . DIRECTORY_SEPARATOR . '..');
define('CONFIG_DIR', PROJECT_ROOT . DIRECTORY_SEPARATOR . 'config');

try {
    require_once(CONFIG_DIR . DIRECTORY_SEPARATOR . 'di.php');

    $app = new \Phalcon\Mvc\Micro();
    $app->setDI($di);

    $app->handle();
} catch (\Exception $e) {
    //TODO: write code
}