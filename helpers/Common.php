<?php
namespace Helpers;

use \Includes\HttpAbstractException;
use \Phalcon\Http\Response;

/**
 * Class Common.
 *
 * Contains various methods for application.
 */
class Common
{
    /**
     * Construct response object.
     *
     * @param int $code response code (200 is default).
     * @param string|null $message additional response message.
     *
     * @return \Phalcon\Http\Response response object.
     */
    public static function getResponse(
        int $code = 200,
        string $message = null
    ) : Response {
        $response = new Response();
        $response
            ->setStatusCode($code)
            ->setJsonContent([
                HttpAbstractException::CODE_KEY => $code,
                HttpAbstractException::MESSAGE_KEY => $message ?: 'No details message'
            ]);
        return $response;
    }
}
