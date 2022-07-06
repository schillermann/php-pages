<?php
namespace PhpPages\Tests;

use PhpPages\Page\TextPage;
use PhpPages\Response\FakeResponse;
use PhpPages\SimpleOutput;
use PHPUnit\Framework\TestCase;

class TextPageTest extends TestCase
{
    function testCanGetResponse(): void
    {
        $response = new FakeResponse();
        (new TextPage('Hello World!'))
            ->viaOutput(new SimpleOutput())
            ->writeTo($response);

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