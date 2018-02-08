<?php

$di = new \Phalcon\DI\FactoryDefault();

// check config file
if (!file_exists(CONFIG_DIR . DIRECTORY_SEPARATOR . 'config.php')) {
    //TODO: use another exception type
    throw new Exception('Config not exists!');
}

// include and share config
$config = require_once (CONFIG_DIR . DIRECTORY_SEPARATOR . 'config.php');
$di->set('config', $config);

$di->set('db', Phalcon\Db\Adapter\Pdo\Factory::load($config->db));
