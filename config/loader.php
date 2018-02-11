<?php

$loader = new \Phalcon\Loader();

$loader->registerNamespaces([
    'Helpers' => realpath(PROJECT_ROOT . DIRECTORY_SEPARATOR . 'helpers'),
    'Includes' => realpath(PROJECT_ROOT . DIRECTORY_SEPARATOR . 'includes'),
]);

$loader->register();
