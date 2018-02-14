<?php

$loader = new \Phalcon\Loader();

$loader->registerNamespaces([
    'Helpers' => realpath(PROJECT_ROOT . DIRECTORY_SEPARATOR . 'helpers'),
    'Includes' => realpath(PROJECT_ROOT . DIRECTORY_SEPARATOR . 'includes'),
    'Exception' => realpath(
        PROJECT_ROOT . DIRECTORY_SEPARATOR . 'includes'
        . DIRECTORY_SEPARATOR . 'exception'
    ),
    'Entity' => realpath(PROJECT_ROOT . DIRECTORY_SEPARATOR . 'entity'),
]);

$loader->register();
