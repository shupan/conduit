<?php namespace BuildR\Foundation\Tests\Fixtures\Enumeration;

use BuildR\Foundation\Enumeration\AbstractEnumeration;

class HTTPMethod extends AbstractEnumeration {

    const METHOD_GET = 'GET';

    const METHOD_POST = 'POST';

    /* ... */

    private $methodDescriptions = [
        'GET' => 'Description for GET method',
    ];

    public function describe() {
        if(isset($this->methodDescriptions[$this->value])) {
            return $this->methodDescriptions[$this->value];
        }

        return NULL;
    }

}