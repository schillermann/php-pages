<?php
namespace PhpPages\Tests;

use PhpPages\Output\LayoutOutput;
use PhpPages\Output\SimpleOutput;
use PhpPages\Response\FakeResponse;
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
            ->output('PhpPages-Layout', 'Hello {TEMPLATE}! {TEMPLATE-SIDEBAR}')
            ->output('PhpPages-Template', 'Mario')
            ->output('PhpPages-Template-Sidebar', 'You are logged in.')
            ->__toString();

        $expected = <<<OUTPUT
HTTP/1.1 200 OK
Content-Length: 12
Content-Type: text/plain

Hello Mario! You are logged in.
OUTPUT;

        $this->assertEquals(
            $expected,
            $output
        );
    }

    function testCanGetResponse(): void
    {
        $response = new FakeResponse();

        (new LayoutOutput(
            new SimpleOutput()
        ))
            ->output('Content-Length', 12)
            ->output('Content-Type', 'text/plain')
            ->output('PhpPages-Layout', 'Hello {TEMPLATE}! {TEMPLATE-SIDEBAR}')
            ->output('PhpPages-Template', 'Mario')
            ->output('PhpPages-Template-Sidebar', 'You are logged in.')
            ->write($response);

        $expected = <<<OUTPUT
HTTP/1.1 200 OK
Content-Length: 12
Content-Type: text/plain

Hello Mario! You are logged in.
OUTPUT;

        $this->assertEquals(
            $expected,
            $response->__toString()
        );
    }
}