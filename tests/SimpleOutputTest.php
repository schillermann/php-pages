<?php

namespace PhpPages\Tests;

use PhpPages\PageInterface;
use PhpPages\Response\FakeResponse;
use PhpPages\SimpleOutput;
use PHPUnit\Framework\TestCase;

class SimpleOutputTest extends TestCase
{
    function testCanGetOutputAsString(): void
    {
        $output = (new SimpleOutput())
            ->withMetadata('Content-Type', 'text/plain')
            ->withMetadata(PageInterface::BODY, 'Hello World!')
            ->withMetadata(PageInterface::BODY, 'This is a test.');

        $expected = <<<OUTPUT
        HTTP/1.1 200 OK
        Content-Length: 28
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
            ->withMetadata(PageInterface::BODY, 'Hello World!')
            ->withMetadata(PageInterface::BODY, 'This is a test.')
            ->writeTo($response);

        $expected = <<<OUTPUT
        HTTP/1.1 200 OK
        Content-Length: 28
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
