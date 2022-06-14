<?php
namespace PhpPages\Tests;

use PhpPages\RequestFake;
use PhpPages\ResponseFake;
use PhpPages\Session;
use PhpPages\SimpleOutput;
use PhpPages\TextPage;
use PHPUnit\Framework\TestCase;

class SessionTest extends TestCase
{
    function testCanGetResponse(): void
    {
        $request = new RequestFake(
            'GET',
            '/',
            'HTTP/1.1'
        );
        $response = new ResponseFake();

        (new Session(
            new TextPage('Hello World!'))
        )
            ->with($request)
            ->via(new SimpleOutput())
            ->print($response);

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