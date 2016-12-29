<?php namespace BuildR\Foundation\Tests;

use BuildR\Foundation\Tests\Fixtures\ArrayObject\DummyArrayObject;

class ArrayObjectTest extends \PHPUnit_Framework_TestCase {

    /**
     * @type \BuildR\Foundation\Object\AbstractArrayObject
     */
    protected $object;

    protected function setUp() {
        $this->object = new DummyArrayObject();

        parent::setUp();
    }

    protected function tearDown() {
        unset($this->object);

        parent::tearDown();
    }

    public function testCountingWorks() {
        $this->assertCount(2, $this->object);
    }

    public function testArrayConversionWorks() {
        $result = $this->object->toArray();

        $this->assertCount(2, $result);
        $this->assertTrue(is_array($result));
        $this->assertArrayHasKey('key', $result);
    }

    public function testItReturnsTheCorrectIterator() {
        $iterator = $this->object->getIterator();

        $this->assertInstanceOf(\ArrayIterator::class, $iterator);
        $this->assertEquals(2, iterator_count($iterator));

        $iterator->rewind();
        $this->assertTrue($iterator->valid());
        $this->assertEquals('value', $iterator->current());
    }

    public function testObjectIsAccessibleAsArray() {
        //offsetGet
        $this->assertEquals('value', $this->object['key']);
        $this->assertTrue(is_array($this->object['nested']));

        //offsetIsset
        $this->assertTrue(isset($this->object['nested']));
        $this->assertFalse(isset($this->object['nonExistingKey']));

        //offsetSet
        $this->object['test'] = 'testValue';
        $this->assertArrayHasKey('test', $this->object);
        $this->assertEquals('testValue', $this->object['test']);

        //offsetUnset
        unset($this->object['test']);
        $this->assertArrayNotHasKey('test', $this->object);
        $this->assertNull($this->object['test']);
    }

    public function testSerializationANdUnSerialization() {
        $serialized = $this->object->serialize();

        $this->assertEquals('a:2:{s:3:"key";s:5:"value";s:6:"nested";a:1:{s:3:"key";s:5:"value";}}', $serialized);

        unset($this->object['key'], $this->object['nested']);
        $this->assertCount(0, $this->object);

        $this->object->unserialize($serialized);

        $this->assertEquals('value', $this->object['key']);
        $this->assertTrue(is_array($this->object['nested']));
        $this->assertTrue(isset($this->object['nested']));
        $this->assertFalse(isset($this->object['nonExistingKey']));
    }

}
