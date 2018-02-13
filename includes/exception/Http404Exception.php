<?php
namespace Includes\Exception;

use Includes\HttpAbstractException;

/**
 * Class Http404Exception.
 *
 * Message and code for 404 http code.
 */
class Http404Exception extends HttpAbstractException {
    /**
     * Contains http message.
     */
    const HTTP_MESSAGE = 'Not Found';

    /**
     * Contains http code.
     */
    const HTTP_CODE = 404;
}