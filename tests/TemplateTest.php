<?php
namespace PhpPages\Tests;

use PhpPages\Template\SimpleTemplate;
use PHPUnit\Framework\TestCase;

class TemplateTest extends TestCase
{
    function testCanBuildTemplate(): void
    {
        $pageContent = <<<'PAGE'
        <h1>Hello <?= $name ?>!</h1>
        PAGE;

        $pageFileHandle = tmpfile();
        fwrite($pageFileHandle, $pageContent);
        $pageTemplateFile = stream_get_meta_data($pageFileHandle)['uri'];

        $content = (new SimpleTemplate(
            $pageTemplateFile
        ))
            ->withParam('name', 'Mario')
            ->content();

        fclose($pageFileHandle);
  
        $expected = <<<OUTPUT
        <h1>Hello Mario!</h1>
        OUTPUT;

        $this->assertEquals(
            $expected,
            $content
        );
    }
}