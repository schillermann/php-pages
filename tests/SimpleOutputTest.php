<?php
namespace PhpPages\Tests;

use PhpPages\Response\FakeResponse;
use PhpPages\SimpleOutput;
use PHPUnit\Framework\TestCase;

class SimpleOutputTest extends TestCase
{
    function testCanGetOutputAsString(): void
    {
        $output = (new SimpleOutput())
            ->withMetadata('Content-Type', 'text/plain')
            ->withMetadata('PhpPages-Body', 'Hello World!')
            ->withMetadata('PhpPages-Body', 'This is a test.')
            ->__toString();

        $expected = <<<OUTPUT
        HTTP/1.1 200 OK
        Content-Length: 29
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

        (new SimpleOutput())
            ->withMetadata('Content-Type', 'text/plain')
            ->withMetadata('PhpPages-Body', 'Hello World!')
            ->withMetadata('PhpPages-Body', 'This is a test.')
            ->writeTo($response);

        $expected = <<<OUTPUT
        HTTP/1.1 200 OK
        Content-Length: 29
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