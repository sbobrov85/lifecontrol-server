<?php

//define path constants
define('PROJECT_ROOT', __DIR__ . DIRECTORY_SEPARATOR . '..');
define('CONFIG_DIR', PROJECT_ROOT . DIRECTORY_SEPARATOR . 'config');

try {
    require_once(CONFIG_DIR . DIRECTORY_SEPARATOR . 'loader.php');
    require_once(CONFIG_DIR . DIRECTORY_SEPARATOR . 'di.php');

    $app = new \Phalcon\Mvc\Micro();

    $app->setDI($di);

    // enable logging and share it
    $loggerConfig = $di->get('config')->get('logger');
    $logger = \Phalcon\Logger\Factory::load($loggerConfig);
    $di->set('logger', $logger);
    $logger->info('Logger init success');

    $logger->info('Adding not found route');
    $app->notFound(function() {
        throw new Includes\Exception\Http404Exception();
    });

    $logger->info('Scan modules and mount routes');
    Helpers\Module::collectRoutes($app);

    // add response handler
    $app->after(function () use ($app) {
        $result = $app->getReturnedValue();

        if (is_array($result)) {
           $app->response->setContent(json_encode($result));
        } elseif (empty($result)) {
            $app->response->setContent('204', 'No Content');
        } else {
            throw new Exception('Bad response');
        }

        $app->response->send();
    });

    $app->handle();
} catch (Includes\AbstractHttpException $e) {
    Helpers\Common::getResponse($e->getCode(), $e->getMessage())->send();
} catch (\Phalcon\Http\Request\Exception $e) {
    Helpers\Common::getResponse(400)->send();
} catch (\Exception $e) { // log any other exceptions...
    if (isset($logger)) {
        $logger->critical("Critical server error:\n$e");
    }
    Helpers\Common::getResponse(500)->send();
}