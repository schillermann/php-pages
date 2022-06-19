<?php
namespace PhpPages\Tests;

use PhpPages\Output\SimpleOutput;
use PhpPages\Page\TextPage;
use PhpPages\Request\FakeRequest;
use PhpPages\Response\FakeResponse;
use PhpPages\Session;
use PHPUnit\Framework\TestCase;

class SessionTest extends TestCase
{
    function testCanGetResponse(): void
    {
        $request = new FakeRequest(
            'GET',
            '/',
            'HTTP/1.1'
        );
        $response = new FakeResponse();

        (new Session(
            new TextPage('Hello World!'))
        )
            ->page($request)
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