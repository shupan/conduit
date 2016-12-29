<?php namespace BuildR\Foundation\Tests\Enumeration;


use BuildR\Foundation\Exception\BadMethodCallException;
use BuildR\Foundation\Exception\UnexpectedValueException;
use BuildR\Foundation\Tests\Fixtures\Enumeration\HTTPMethod;

class EnumerationTest extends \PHPUnit_Framework_TestCase {

    /**
     * @type \BuildR\Foundation\Tests\Fixtures\Enumeration\HTTPMethod
     */
    protected $enumeration;

    public function setUp() {
        $this->enumeration = HTTPMethod::METHOD_GET();

        parent::setUp();
    }

    public function tearDown() {
        unset($this->enumeration);

        parent::tearDown();
    }

    public function wrongKeyValidationProvider() {
        return [
            [FALSE, BadMethodCallException::class, 'The key must be a string! boolean given!'],
            [2.8, BadMethodCallException::class, 'The key must be a string! double given!'],
            [7E-10, BadMethodCallException::class, 'The key must be a string! double given!'],
            [243, BadMethodCallException::class, 'The key must be a string! integer given!'],
            [NULL, BadMethodCallException::class, 'The key must be a string! NULL given!'],
            [[], BadMethodCallException::class, 'The key must be a string! array given!'],
        ];
    }

    public function wrongConstructorParameterProvider() {
        return [
            ['PUT', UnexpectedValueException::class, 'This enumeration is not contains any constant like: PUT'],
            [FALSE, UnexpectedValueException::class, 'This enumeration is not contains any constant like: '],
            [150, UnexpectedValueException::class, 'This enumeration is not contains any constant like: 150'],
            [NULL, UnexpectedValueException::class, 'This enumeration is not contains any constant like: '],
        ];
    }

    /**
     * @dataProvider wrongKeyValidationProvider
     */
    public function testIsThrowsExceptionWhenCalledValidationWithNonValidInput($type, $exClass, $exString) {
        $this->setExpectedException($exClass, $exString);
        HTTPMethod::isValidKey($type);
    }

    /**
     * @dataProvider wrongConstructorParameterProvider
     */
    public function testIsThrowsAnExceptionWhenConstructedWithUnknownValue($value, $exClass, $exString) {
        $this->setExpectedException($exClass, $exString);
        new HTTPMethod($value);
    }

    public function testIsReturnsEnumerationAsValidArray() {
        $expected = [
            'METHOD_GET' => 'GET',
            'METHOD_POST' => 'POST',
        ];

        $result = HTTPMethod::toArray();

        $this->assertCount(count($expected), $result);
        $this->assertEquals($expected, $result);
        $this->assertArrayHasKey('METHOD_GET', $result);
    }

    public function testItReturnsTheEnumerationKeysProperly() {
        $expected = ['METHOD_GET', 'METHOD_POST'];

        $result = HTTPMethod::getKeys();

        $this->assertCount(count($expected), $result);
        $this->assertEquals($expected, $result);
    }

    public function testIsProperlyValidatesKeys() {
        $this->assertTrue(HTTPMethod::isValidKey('METHOD_GET'));
        $this->assertFalse(HTTPMethod::isValidKey(''));
        $this->assertFalse(HTTPMethod::isValidKey('PUT'));
    }

    public function testIsFindsKeyByValue() {
        $this->assertEquals('METHOD_GET', HTTPMethod::find('GET'));

        //Should be case-sensitive
        $this->assertNull(HTTPMethod::find('gEt'));

        //Invalid inputs
        $this->assertNull(HTTPMethod::find('TEST'));
        $this->assertNull(HTTPMethod::find(NULL));
        $this->assertNull(HTTPMethod::find(FALSE));
        $this->assertNull(HTTPMethod::find(25));
        $this->assertNull(HTTPMethod::find([]));
    }

    public function testItReturnsValidInstances() {
        $this->assertInstanceOf(HTTPMethod::class, $this->enumeration);
    }

    public function testIsCountTheEnumerationLengthCorrectly() {
        $this->assertTrue(is_int(HTTPMethod::count()));
        $this->assertEquals(2, HTTPMethod::count());
    }

    public function testInstancesCanReturnsTheCorrectValue() {
        $this->assertEquals('GET', $this->enumeration->getValue());
    }

    public function testInstancesCanValidateValues() {
        $this->assertTrue($this->enumeration->isValid('GET'));
        $this->assertTrue($this->enumeration->isValid('POST'));
        $this->assertFalse($this->enumeration->isValid('NON_EXIST'));
    }

    public function testItConvertsToStringCorrectly() {
        $this->assertEquals('GET', $this->enumeration->__toString());
    }

    public function testInstancesReturnsKeyCorrectly() {
        $this->assertEquals('METHOD_GET', $this->enumeration->getKey());
    }
}