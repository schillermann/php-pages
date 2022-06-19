<?php
namespace PhpPages\Tests;

use PhpPages\Template\LayoutTemplate;
use PhpPages\Template\PageTemplate;
use PHPUnit\Framework\TestCase;

class TemplateTest extends TestCase
{
    function testCanBuildTemplate(): void
    {
        $layoutTemplateContent = <<<'LAYOUT'
<!DOCTYPE html>
<html>
  <head>
    <title><?= $params['title']?></title>
  </head>
  <body>
    <main>
      {TEMPLATE}
    </main>
  </body>
</html>
LAYOUT;

        $pageTemplateContent = <<<'PAGE'
<h1>Hello Test!</h1>
PAGE;

        $layoutTemplateFileHandle = tmpfile();
        fwrite($layoutTemplateFileHandle, $layoutTemplateContent);
        $layoutTemplateFile = stream_get_meta_data($layoutTemplateFileHandle)['uri'];

        $pageTemplateFileHandle = tmpfile();
        fwrite($pageTemplateFileHandle, $pageTemplateContent);
        $pageTemplateFile = stream_get_meta_data($pageTemplateFileHandle)['uri'];

        $content = (new PageTemplate(
            new LayoutTemplate(
                $layoutTemplateFile
            ),
            $pageTemplateFile,
            '{TEMPLATE}'
        ))
            ->content(['title' => 'Template Test']);
        
        fclose($layoutTemplateFileHandle);
        fclose($pageTemplateFileHandle);
     
        $expected = <<<OUTPUT
<!DOCTYPE html>
<html>
  <head>
    <title>Template Test</title>
  </head>
  <body>
    <main>
      <h1>Hello Test!</h1>
    </main>
  </body>
</html>
OUTPUT;

        $this->assertEquals(
            $expected,
            $content
        );
    }
}