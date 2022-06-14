<?php
namespace PhpPages\Tests;

use PhpPages\ResponseFake;
use PhpPages\SimpleOutput;
use PhpPages\TextPage;
use PHPUnit\Framework\TestCase;

class TextPageTest extends TestCase
{
    function testCanGetResponse(): void
    {
        $response = new ResponseFake();
        (new TextPage('Hello World!'))
            ->via(new SimpleOutput())
            ->print($response);

        $expected = <<<OUTPUT
HTTP/1.1 200 OK
Content-Type: text/plain
Content-Length: 12

Hello World!
OUTPUT;

        $this->assertEquals(
            $expected,
            $response->__toString()
        );
    }
}