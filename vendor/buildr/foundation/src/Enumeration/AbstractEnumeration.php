<?php namespace BuildR\Foundation\Enumeration;

use BuildR\Foundation\Exception\BadMethodCallException;
use BuildR\Foundation\Exception\UnexpectedValueException;
use \ReflectionClass;

/**
 * Solves a common PHP problem, that language not has enumeration type, by
 * allowing class constants to used to be enumeration
 * values thought PHP reflection API.
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
abstract class AbstractEnumeration {

    /**
     * @type array
     */
    private static $cache = [];

    /**
     * @type string
     */
    protected $value;

    /**
     * AbstractEnumeration Constructor. Create a new instance from this enumeration.
     * When the given value is not a valid element of the current enumeration a
     * UnexpectedValueException will be thrown.
     *
     * @param string $value The
     *
     * @throws \BuildR\Foundation\Exception\UnexpectedValueException
     */
    public function __construct($value) {
        if(!$this->isValid($value)) {
            throw new UnexpectedValueException('This enumeration is not contains any constant like: ' . $value);
        }

        $this->value = $value;
    }

    /**
     * Returns the key of the current element
     *
     * @return NULL|string
     */
    public function getKey() {
        $value = self::find($this->value);

        //In real life NULL should be never happen!
        return ($value === FALSE) ? NULL : $value;
    }

    /**
     * Returns the current element value
     *
     * @return string
     */
    public function getValue() {
        return $this->value;
    }

    /**
     * Validate the currently set value in the enumeration
     *
     * @param string $value
     *
     * @return bool
     */
    public function isValid($value) {
        return (bool) in_array($value, self::toArray());
    }

    /**
     * Returns the current value as string representation
     *
     * @return string
     */
    public function __toString() {
        return (string) $this->value;
    }

    /**
     * Translates the current enumeration class to an array. This function use
     * runtime caching mechanism, all enumeration constants stored in a static
     * value.
     *
     * @return array
     */
    public static function toArray() {
        $enumClass = get_called_class();

        if(!array_key_exists($enumClass, self::$cache)) {
            $reflector = new ReflectionClass($enumClass);
            self::$cache[$enumClass] = $reflector->getConstants();
        }

        return self::$cache[$enumClass];
    }

    /**
     * Find a key in the enumeration by its value. If this value
     * is exist in the current enumeration this function returns the
     * corresponding key, NULL otherwise.
     *
     * @param string $value The value
     *
     * @return NULL|string
     */
    public static function find($value) {
        $result = array_search($value, self::toArray(), TRUE);

        return ($result === FALSE) ? NULL : $result;
    }

    /**
     * Returns the length of the current enumeration.
     *
     * @return ins
     */
    public static function count() {
        return (int) count(self::toArray());
    }

    /**
     * Returns all key from the current enumeration as array
     *
     * @return array
     */
    public static function getKeys() {
        return array_keys(self::toArray());
    }

    /**
     * Determines that the given key is exist in the current enumeration.
     * If the key is not a string a BadMethodCallException will be thrown.
     *
     * @param string $key The desired key
     *
     * @return bool
     *
     * @throws \BuildR\Foundation\Exception\BadMethodCallException
     */
    public static function isValidKey($key) {
        if(!is_string($key)) {
            throw new BadMethodCallException('The key must be a string! ' . gettype($key) . ' given!');
        }

        return array_key_exists($key, self::toArray());
    }

    /**
     * This PHP magic method is a proxy for creating new instance from
     * enumerations. The method name used as the class constructor parameter.
     * The passed arguments ignored. Validation is not needed here because
     * is handled by the constructor itself.
     *
     * @param string $name The method name
     * @param array $arguments Passed arguments
     *
     * @return static
     */
    public static function __callStatic($name, $arguments) {
        return new static(constant("static::$name"));
    }
}
