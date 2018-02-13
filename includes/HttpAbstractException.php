<?php
namespace Includes;

/**
 * Class HttpAbstractException.
 *
 * Abstract HTTP exception (throw http exception by name).
 * Add HTTP_CODE and HTTP message constants for extended classes.
 */
abstract class HttpAbstractException extends \Exception {
    /**
     * Contains code key.
     */
    const CODE_KEY = 'key';

    /**
     * Contains message key.
     */
    const MESSAGE_KEY = 'message';

    //--------------------------------------------------------------------------

    /**
     * Override standard construct method.
     */
    public function __construct()
    {
        parent::__construct(static::HTTP_MESSAGE, static::HTTP_CODE);
    }
}
