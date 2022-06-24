<?php
namespace PhpPages\Tests;

use PhpPages\Output\BaseOutput;
use PhpPages\Output\LayoutOutput;
use PhpPages\Response\FakeResponse;
use PHPUnit\Framework\TestCase;

class LayoutOutputTest extends TestCase
{
    function testCanGetOutputAsString(): void
    {
        $output = (new LayoutOutput(
            new BaseOutput()
        ))
            ->withMetadata('Content-Length', 12)
            ->withMetadata('Content-Type', 'text/plain')
            ->withMetadata('PhpPages-Layout', 'Hello {TEMPLATE}! {TEMPLATE-SIDEBAR}')
            ->withMetadata('PhpPages-Template', 'Mario')
            ->withMetadata('PhpPages-Template-Sidebar', 'You are logged in.')
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
            new BaseOutput()
        ))
            ->withMetadata('Content-Length', 12)
            ->withMetadata('Content-Type', 'text/plain')
            ->withMetadata('PhpPages-Layout', 'Hello {TEMPLATE}! {TEMPLATE-SIDEBAR}')
            ->withMetadata('PhpPages-Template', 'Mario')
            ->withMetadata('PhpPages-Template-Sidebar', 'You are logged in.')
            ->writeTo($response);

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