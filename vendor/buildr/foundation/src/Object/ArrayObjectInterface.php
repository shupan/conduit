<?php namespace BuildR\Foundation\Object;

use \ArrayAccess;
use \IteratorAggregate;
use \Countable;
use \Serializable;
use BuildR\Foundation\Object\ArrayConvertibleInterface;

/**
 * This interface define all the method that an ArrayObject can implement
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
interface ArrayObjectInterface
    extends ArrayAccess,
            ArrayConvertibleInterface,
            IteratorAggregate,
            Countable,
            Serializable {
    
}
