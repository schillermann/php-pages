<?php
namespace PhpPages\Tests;

use PhpPages\Page\PageWithRoutes;
use PhpPages\Page\TextPage;
use PhpPages\SimpleOutput;
use PHPUnit\Framework\TestCase;

class PageWithRoutesTest extends TestCase
{
    function testCanGetProfilePage(): void
    {
        $response = (new PageWithRoutes(
            new TextPage('Page not found')
            
        ))
            ->withRoute(
                '/profile',
                new TextPage('My profile')
            )
            ->withMetadata('PhpPages-Path', '/profile')
            ->viaOutput(new SimpleOutput());
        
        $expected = <<<'PAGE'
        HTTP/1.1 200 OK
        Content-Length: 10
        Content-Type: text/plain

        My profile
        PAGE;

        $this->assertEquals(
            $expected,
            $response->__toString()
        );
    }

    function testCanGetFallbackPage(): void
    {
        $response = (new PageWithRoutes(
            new TextPage('Page not found')
            
        ))
            ->withRoute(
                '/profile',
                new TextPage('My profile')
            )
            ->withMetadata('PhpPages-Path', '/unkown')
            ->viaOutput(new SimpleOutput());
        
        $expected = <<<'PAGE'
        HTTP/1.1 200 OK
        Content-Length: 14
        Content-Type: text/plain

        Page not found
        PAGE;

        $this->assertEquals(
            $expected,
            $response->__toString()
        );
    }
}