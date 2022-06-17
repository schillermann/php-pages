<?php
namespace PhpPages\Tests;

use PhpPages\App;
use PhpPages\PageWithRoutes;
use PhpPages\RequestFake;
use PhpPages\ResponseFake;
use PhpPages\SimpleOutput;
use PhpPages\TextPage;
use PHPUnit\Framework\TestCase;

class AppTest extends TestCase
{
    function testCanGetResponse(): void
    {
        $request = new RequestFake(
            'GET',
            '/profile',
            'HTTP/1.1'
        );
        $response = new ResponseFake();

        (new App(
            new PageWithRoutes(
                '/profile',
                new TextPage('Hello World!'),
                new TextPage('Page not found')
            ),
            new SimpleOutput()
        ))
            ->process(
                $request,
                $response
            );

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