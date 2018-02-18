<?php

$loader = new \Phalcon\Loader();

$loader->registerNamespaces([
    'Helpers' => PROJECT_ROOT . DIRECTORY_SEPARATOR . 'helpers',
    'Includes' => PROJECT_ROOT . DIRECTORY_SEPARATOR . 'includes',
    'Includes\Exception' =>  PROJECT_ROOT . DIRECTORY_SEPARATOR . 'includes'
        . DIRECTORY_SEPARATOR . 'exception',
    'Entity' => PROJECT_ROOT . DIRECTORY_SEPARATOR . 'entity',
    'Modules' => PROJECT_ROOT . DIRECTORY_SEPARATOR . 'modules',
]);

$loader->register();
