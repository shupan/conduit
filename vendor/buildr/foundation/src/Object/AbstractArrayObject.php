<?php namespace BuildR\Foundation\Object;

use BuildR\Foundation\Object\ArrayObjectInterface;
use \ArrayIterator;

/**
 * Common interface for object that can be convertible to array.
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
class AbstractArrayObject implements ArrayObjectInterface {

    /**
     * @type array
     */
    protected $data = [];

    /**
     * @inheritDoc
     */
    public function toArray() {
        return $this->data;
    }

    /**
     * @inheritDoc
     */
    public function count() {
        return (int) count($this->data);
    }

    /**
     * @inheritDoc
     */
    public function getIterator() {
        return new ArrayIterator($this->data);
    }

    /**
     * @inheritDoc
     */
    public function offsetExists($offset) {
        return (bool) isset($this->data[$offset]);
    }

    /**
     * @inheritDoc
     */
    public function offsetGet($offset) {
        return isset($this->data[$offset]) ? $this->data[$offset] : NULL;
    }

    /**
     * @inheritDoc
     */
    public function offsetSet($offset, $value) {
        $this->data[$offset] = $value;
    }

    /**
     * @inheritDoc
     */
    public function offsetUnset($offset) {
        if(isset($this->data[$offset])) {
            unset($this->data[$offset]);
        }
    }

    /**
     * @inheritDoc
     */
    public function serialize() {
        return serialize($this->data);
    }

    /**
     * @inheritDoc
     */
    public function unserialize($serialized) {
        $this->data = unserialize($serialized);
    }

}
