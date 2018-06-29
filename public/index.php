<?php

require_once(implode(DIRECTORY_SEPARATOR, [
    '..',
    'config',
    'defines.php'
]));

try {
    require_once(CONFIG_DIR . DIRECTORY_SEPARATOR . 'loader.php');
    require_once(CONFIG_DIR . DIRECTORY_SEPARATOR . 'di.php');
    $di->set('loader', $loader);

    $app = new \Phalcon\Mvc\Micro();

    $app->setDI($di);

    // enable logging and share it
    $loggerConfig = $di->get('config')->get('logger');
    $logger = \Phalcon\Logger\Factory::load($loggerConfig);
    $di->set('logger', $logger);
    $logger->info('--> Start logging');

    $logger->debug(
        'Current request URI: ' . (new \Phalcon\Http\Request())->getURI()
    );

    $logger->info('Adding not found route');
    $app->notFound(function() {
        throw new \Includes\Exception\Http404Exception();
    });

    // register modules info
    \Helpers\Module::register($app, $logger);

    // add response handler
    $app->after(function () use ($app) {
        $result = $app->getReturnedValue();

        if (is_array($result)) {
            $app->response->setContent(json_encode($result));
        } elseif (!empty($result)) {
            $app->response->setContent($result);
        } elseif (empty($result)) {
            throw new \Includes\Exception\Http204Exception();
        } else {
            throw new Exception('Bad response');
        }

        $app->response->send();
    });

    $app->handle();
} catch (\Includes\HttpAbstractException $e) {
    Helpers\Common::getResponse($e->getCode(), $e->getMessage())->send();
} catch (\Phalcon\Http\Request\Exception $e) {
    Helpers\Common::getResponse(400)->send();
} catch (\Exception $e) {
    // log any other exceptions...
    if (isset($logger)) {
        $logger->critical("Critical server error:\n$e");
    }
    Helpers\Common::getResponse(500)->send();
}
