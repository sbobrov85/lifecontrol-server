<?php
namespace Helpers;

use \Phalcon\Http\Response;

/**
 * Class Common.
 *
 * Contains various methods for application.
 */
class Common {
    /**
     * @param array contains response statuses messages.
     */
    private static $statuses = [
        200 => 'Success',
        204 => 'Not content',
        400 => 'Bad request',
        500 => 'Internal server error'
    ];

    //--------------------------------------------------------------------------

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
    ): Response {
        $response = new Response();
        $responseMessage = self::getResponseStatusMessage($code);
        $response
            ->setStatusCode($code, $responseMessage)
            ->setJsonContent([ //TODO: use  constants from HttpAbstractException
                'code' => $code,
                'message' => $message ?: $responseMessage
            ]);
        return $response;
    }

    //--------------------------------------------------------------------------

    /**
     * Get response status message by code.
     *
     * @param int response code.
     *
     * @return string response status message.
     */
    public static function getResponseStatusMessage(int $code): string
    {
        return self::$statuses[$code] ?? 'Unsupported status';
    }
}