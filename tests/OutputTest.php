<?php
namespace PhpPages\Tests;

use PhpPages\Output\SimpleOutput;
use PhpPages\Response\FakeResponse;
use PHPUnit\Framework\TestCase;

class OutputTest extends TestCase
{
    function testCanGetOutputAsString(): void
    {
        $output = (new SimpleOutput())
            ->output('Content-Length', 12)
            ->output('Content-Type', 'text/plain')
            ->output('PhpPages-Body', 'Hello World!')
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
        $response = new FakeResponse();

        (new SimpleOutput())
            ->output('Content-Length', 12)
            ->output('Content-Type', 'text/plain')
            ->output('PhpPages-Body', 'Hello World!')
            ->write($response);

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