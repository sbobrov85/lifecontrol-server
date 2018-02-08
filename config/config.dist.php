<?php
/**
 * Dist config for application.
 * Rename to config.php and remove comments.
 */

return new \Phalcon\Config([
    'db' => [
        'adapter' => 'sqlite',
        'dbname' => PROJECT_ROOT . DIRECTORY_SEPARATOR . 'lifecontrol.db',
    ],
    'logger' => [
        'adapter' => 'file',
        'name' => PROJECT_ROOT
            . DIRECTORY_SEPARATOR . 'log'
            . DIRECTORY_SEPARATOR . 'common.log',
        'level' => \Phalcon\Logger::DEBUG
    ]
]);
