<?php
namespace PhpPages\Tests;

use PhpPages\Page\LayoutPage;
use PhpPages\Page\SimplePage;
use PhpPages\Response\FakeResponse;
use PhpPages\SimpleOutput;
use PhpPages\Template\SimpleTemplate;
use PHPUnit\Framework\TestCase;

class LayoutTest extends TestCase
{
    function testCanBuildLayout(): void
    {
        $layoutContent = <<<'LAYOUT'
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="utf-8">
            <title><?= $title ?></title>
        </head>
        <body>
            <header>
                {TEMPLATE}
            </header>
            <main>
                {TEMPLATE}
            </main>
        </body>
        </html>
        LAYOUT;

        $layoutFileHandle = tmpfile();
        fwrite($layoutFileHandle, $layoutContent);
        $layoutTemplateFile = stream_get_meta_data($layoutFileHandle)['uri'];

        $response = new FakeResponse();
        (new LayoutPage(
            new SimpleTemplate($layoutTemplateFile),
            [
                'title' => 'Layout Test'
            ]
        ))
            ->withPage(new SimplePage('Head Page'))
            ->withPage(new SimplePage('Cool content'))
            ->viaOutput(new SimpleOutput())
            ->writeTo($response);

        fclose($layoutFileHandle);

        $expected = <<<'PAGE'
        HTTP/1.1 200 OK
        Content-Length: 229

        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="utf-8">
            <title>Layout Test</title>
        </head>
        <body>
            <header>
                
        Head Page

            </header>
            <main>
                
        Cool content

            </main>
        </body>
        </html>
        PAGE;

        $this->assertEquals(
            $expected,
            $response->__toString()
        );
    }
}