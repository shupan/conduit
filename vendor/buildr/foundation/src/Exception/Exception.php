<?php namespace BuildR\Foundation\Exception;

use \Exception as VanillaException;

/**
 * Base Exception
 *
 * BuildR PHP Framework
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package Foundation
 * @subpackage Exception
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
class Exception extends VanillaException{

    /**
     * Create a new exception with a prepared message. Message is prepared using vsptintf()
     * if you provide a format.
     *
     * @param string $message The exception message
     * @param array $format The format elements
     * @param int $code Exception code
     * @param \Exception $previous Previous exception class
     *
     * @return \Exception
     */
    public static function createByFormat($message = "", $format = [], $code = 0, VanillaException $previous = NULL) {
        if(!empty($format)) {
            $message = vsprintf($message, $format);
        }

        return new static($message, $code, $previous);
    }

}
