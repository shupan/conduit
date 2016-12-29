<?php namespace BuildR\Foundation\Object;

/**
 * Common interface for object that can be convertible to string.
 *
 * BuildR PHP Framework
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package Foundation
 * @subpackage Object
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
interface StringConvertibleInterface {

    /**
     * Converts the object into a string representation
     *
     * @return string
     */
    public function __toString();

    /**
     * Converts the object into a string representation. Same as default PHP magic (__toString())
     * but for compatibility reasons included without the trailing __ characters.
     * This allow compatibility with other 'Convertible' interface, like ArrayConvertibleInterface.
     *
     * Because our coding standard only allow to use the __ character prefix on built-in magic methods.
     *
     * @return string
     */
    public function toString();

}
