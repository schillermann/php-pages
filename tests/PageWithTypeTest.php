<?php
namespace PhpPages\Tests;

use PhpPages\Page\PageWithType;
use PhpPages\Page\SimplePage;
use PhpPages\SimpleOutput;
use PHPUnit\Framework\TestCase;

class PageWithTypeTest extends TestCase
{
    function testCanResponseWithType(): void
    {
        $page = new PageWithType(
            new SimplePage('Hello World!'),
            'text/html'
        );

        $expected = <<<'PAGE'
        HTTP/1.1 200 OK
        Content-Length: 12
        Content-Type: text/html

        Hello World!
        PAGE;

        $this->assertEquals(
            $expected,
            $page->viaOutput(new SimpleOutput())->__toString()
        );
    }
}