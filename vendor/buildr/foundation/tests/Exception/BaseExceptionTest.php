<?php namespace BuildR\Foundation\Tests\Exception;

use BuildR\Foundation\Exception\Exception;
use BuildR\Foundation\Exception\InvalidArgumentException;
use BuildR\Foundation\Exception\RuntimeException;

class BaseExceptionTest extends \PHPUnit_Framework_TestCase {

    public function testItReturnsProperExceptionWhenNoFormattingProvided() {
        $message = 'Normal Exception Message!';

        $eNull = Exception::createByFormat($message, NULL);
        $eEmptyArray = Exception::createByFormat($message, []);
        $eBoolean = Exception::createByFormat($message, FALSE);

        $this->assertEquals($message, $eNull->getMessage());
        $this->assertEquals($message, $eEmptyArray->getMessage());
        $this->assertEquals($message, $eBoolean->getMessage());
    }

    public function testChildrenHasValidTypes() {
        $message = 'Normal Exception Message!';

        $e = InvalidArgumentException::createByFormat($message);

        $this->assertInstanceOf(InvalidArgumentException::class, $e);
        $this->assertEquals($message, $e->getMessage());
    }

    public function testExceptionMessageFormatting() {
        $message = 'The class %s, is not found!. Loading tried for %d times.';
        $messageData = ['TestClass', 6];
        $expectedMessage = vsprintf($message, $messageData);

        $e = RuntimeException::createByFormat($message, $messageData);

        $this->assertInstanceOf(RuntimeException::class, $e);
        $this->assertEquals($expectedMessage, $e->getMessage());
    }

}