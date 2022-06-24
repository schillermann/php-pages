<?php
namespace PhpPages\Tests;

use PhpPages\Template\SimpleTemplate;
use PHPUnit\Framework\TestCase;

class TemplateTest extends TestCase
{
    function testCanBuildTemplate(): void
    {
        $pageContent = <<<'PAGE'
<h1>Hello <?= $this->params['name'] ?>!</h1>
PAGE;

        $pageFileHandle = tmpfile();
        fwrite($pageFileHandle, $pageContent);
        $pageTemplateFile = stream_get_meta_data($pageFileHandle)['uri'];

        $content = (new SimpleTemplate(
            $pageTemplateFile,
            ['name' => 'Mario']
        ))
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

    function testCanBuildTemplateWithLayout(): void
    {
        $layoutContent = <<<'LAYOUT'
<!DOCTYPE html>
<html>
  <head>
    <title><?= $this->params['title']?></title>
  </head>
  <body>
    <main>
      {TEMPLATE}
    </main>
  </body>
</html>
LAYOUT;

        $pageContent = <<<'PAGE'
<h1>Hello <?= $this->params['name'] ?>!</h1>
PAGE;

        $layoutFileHandle = tmpfile();
        fwrite($layoutFileHandle, $layoutContent);
        $layoutFile = stream_get_meta_data($layoutFileHandle)['uri'];

        $pageFileHandle = tmpfile();
        fwrite($pageFileHandle, $pageContent);
        $pageFile = stream_get_meta_data($pageFileHandle)['uri'];

        $content = (new SimpleTemplate(
            $pageFile,
            ['name' => 'Mario']
        ))
            ->withLayout(
              new SimpleTemplate(
                  $layoutFile,
                  ['title' => 'Template Test']
              ),
                '{TEMPLATE}'
            )
            ->content();
        
        fclose($layoutFileHandle);
        fclose($pageFileHandle);
     
        $expected = <<<OUTPUT
<!DOCTYPE html>
<html>
  <head>
    <title>Template Test</title>
  </head>
  <body>
    <main>
      <h1>Hello Mario!</h1>
    </main>
  </body>
</html>
OUTPUT;

        $this->assertEquals(
            $expected,
            $content
        );
    }

    function testPlaceholderNotFound(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $layoutContent = <<<'LAYOUT'
<!DOCTYPE html>
<html>
  <head>
    <title><?= $this->params['title']?></title>
  </head>
  <body>
    <main>
      {TEMPLATE}
    </main>
  </body>
</html>
LAYOUT;

        $layoutFileHandle = tmpfile();
        fwrite($layoutFileHandle, $layoutContent);
        $layoutFile = stream_get_meta_data($layoutFileHandle)['uri'];

        (new SimpleTemplate('file-does-not-exist.html'))
            ->withLayout(
              new SimpleTemplate(
                  $layoutFile,
                  ['title' => 'Template Test']
              ),
                '{TEMPLATE-NOT-EXISTS}'
            );

        fclose($layoutFileHandle);
    }
}