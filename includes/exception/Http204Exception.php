<?php
namespace Includes\Exception;

use Includes\HttpAbstractException;

/**
 * Class Http204Exception.
 *
 * Message and code for 204 http code.
 */
class Http204Exception extends HttpAbstractException {
    /**
     * Contains http message.
     */
    const HTTP_MESSAGE = null;

    /**
     * Contains http code.
     */
    const HTTP_CODE = 204;
}