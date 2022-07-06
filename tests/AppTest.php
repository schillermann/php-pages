<?php
namespace PhpPages\Tests;

use PhpPages\App;
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
            (new PageWithRoutes(
                new TextPage('Page not found')
            ))
                ->withRoute(
                    '/profile',
                    new TextPage('Hello World!')
                )
        ))
            ->start($request, $response);

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