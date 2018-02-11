<?php
namespace Includes\Exception;

use Includes;

/**
 * Class Http404Exception.
 *
 * Message and code for 404 http code.
 */
class Http404Exception extends AbstractHttpException {
    /**
     * Contains http message.
     */
    const HTTP_MESSAGE = 'Not Found';

    /**
     * Contains http code.
     */
    const HTTP_CODE = 404;
}