<?php
namespace PhpPages\Tests;

use PhpPages\Template\PhpTemplate;
use PHPUnit\Framework\TestCase;

class PhpTemplateTest extends TestCase
{
    function testCanBuildTemplate(): void
    {
        $fileHandle = tmpfile();
        fwrite($fileHandle, '<h1>Hello <?= $name ?>!</h1>');
        $filename = stream_get_meta_data($fileHandle)['uri'];

        $template = (new PhpTemplate(
            $filename
        ))
            ->withParameter('name', 'Mario');
  
        $expected = <<<OUTPUT
        <h1>Hello Mario!</h1>
        OUTPUT;

        $this->assertEquals(
            $expected,
            $template
        );

        fclose($fileHandle);
    }
}