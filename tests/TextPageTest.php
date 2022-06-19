<?php
namespace PhpPages\Tests;

use PhpPages\Output\SimpleOutput;
use PhpPages\Page\TextPage;
use PhpPages\Response\FakeResponse;
use PHPUnit\Framework\TestCase;

class TextPageTest extends TestCase
{
    function testCanGetResponse(): void
    {
        $response = new FakeResponse();
        (new TextPage('Hello World!'))
            ->output(new SimpleOutput())
            ->write($response);

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