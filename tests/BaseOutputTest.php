<?php
namespace PhpPages\Tests;

use PhpPages\Output\BaseOutput;
use PhpPages\Response\FakeResponse;
use PHPUnit\Framework\TestCase;

class BaseOutputTest extends TestCase
{
    function testCanGetOutputAsString(): void
    {
        $output = (new BaseOutput())
            ->withMetadata('Content-Length', 12)
            ->withMetadata('Content-Type', 'text/plain')
            ->withMetadata('PhpPages-Body', 'Hello World!')
            ->withMetadata('PhpPages-Body', 'This is a test.')
            ->__toString();

        $expected = <<<OUTPUT
HTTP/1.1 200 OK
Content-Length: 12
Content-Type: text/plain

Hello World!
This is a test.
OUTPUT;

        $this->assertEquals(
            $expected,
            $output
        );
    }

    function testCanGetResponse(): void
    {
        $response = new FakeResponse();

        (new BaseOutput())
            ->withMetadata('Content-Length', 12)
            ->withMetadata('Content-Type', 'text/plain')
            ->withMetadata('PhpPages-Body', 'Hello World!')
            ->withMetadata('PhpPages-Body', 'This is a test.')
            ->writeTo($response);

        $expected = <<<OUTPUT
HTTP/1.1 200 OK
Content-Length: 12
Content-Type: text/plain

Hello World!
This is a test.
OUTPUT;

        $this->assertEquals(
            $expected,
            $response->__toString()
        );
    }
}