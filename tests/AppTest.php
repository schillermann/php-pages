<?php
namespace PhpPages\Tests;

use PhpPages\App;
use PhpPages\Output\SimpleOutput;
use PhpPages\Page\PageWithRoutes;
use PhpPages\Page\TextPage;
use PhpPages\Request\FakeRequest;
use PhpPages\Response\FakeResponse;
use PHPUnit\Framework\TestCase;

class AppTest extends TestCase
{
    function testCanGetResponse(): void
    {
        $request = new FakeRequest(
            'GET',
            '/profile',
            'HTTP/1.1'
        );
        $response = new FakeResponse();

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