<?php namespace BuildR\Foundation\Tests\Fixtures\ArrayObject;

use BuildR\Foundation\Object\AbstractArrayObject;

class DummyArrayObject extends AbstractArrayObject {

    protected $data = [
        'key' => 'value',
        'nested' => [
            'key' => 'value',
        ],
    ];

}
