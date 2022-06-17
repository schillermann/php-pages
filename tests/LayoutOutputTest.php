<?php
namespace PhpPages\Tests;

use PhpPages\LayoutOutput;
use PhpPages\ResponseFake;
use PhpPages\SimpleOutput;
use PHPUnit\Framework\TestCase;

class LayoutOutputTest extends TestCase
{
    function testCanGetOutputAsString(): void
    {
        $output = (new LayoutOutput(
            new SimpleOutput()
        ))
            ->output('Content-Length', 12)
            ->output('Content-Type', 'text/plain')
            ->output('PhpPages-Layout', 'Hello {TEMPLATE}!')
            ->output('PhpPages-Template', 'Mario')
            ->__toString();

        $expected = <<<OUTPUT
HTTP/1.1 200 OK
Content-Length: 12
Content-Type: text/plain

Hello Mario!
OUTPUT;

        $this->assertEquals(
            $expected,
            $output
        );
    }

    function testCanGetResponse(): void
    {
        $response = new ResponseFake();

        (new LayoutOutput(
            new SimpleOutput()
        ))
            ->output('Content-Length', 12)
            ->output('Content-Type', 'text/plain')
            ->output('PhpPages-Layout', 'Hello {TEMPLATE}!')
            ->output('PhpPages-Template', 'Mario')
            ->write($response);

        $expected = <<<OUTPUT
HTTP/1.1 200 OK
Content-Length: 12
Content-Type: text/plain

Hello Mario!
OUTPUT;

        $this->assertEquals(
            $expected,
            $response->__toString()
        );
    }
}