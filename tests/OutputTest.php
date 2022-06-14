<?php
namespace PhpPages\Tests;

use PhpPages\ResponseFake;
use PhpPages\SimpleOutput;
use PHPUnit\Framework\TestCase;

class OutputTest extends TestCase
{
    function testCanGetOutputAsString(): void
    {
        $output = (new SimpleOutput())
            ->metadata('Content-Length', 12)
            ->metadata('Content-Type', 'text/plain')
            ->metadata('PhpPages-Body', 'Hello World!')
            ->__toString();

        $expected = <<<OUTPUT
HTTP/1.1 200 OK
Content-Length: 12
Content-Type: text/plain

Hello World!
OUTPUT;

        $this->assertEquals(
            $expected,
            $output
        );
    }

    function testCanGetResponse(): void
    {
        $response = new ResponseFake();

        (new SimpleOutput())
            ->metadata('Content-Length', 12)
            ->metadata('Content-Type', 'text/plain')
            ->metadata('PhpPages-Body', 'Hello World!')
            ->print($response);

        $expected = <<<OUTPUT
HTTP/1.1 200 OK
Content-Length: 12
Content-Type: text/plain

Hello World!
OUTPUT;

        $this->assertEquals(
            $expected,
            $response->__toString()
        );
    }
}