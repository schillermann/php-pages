<?php
namespace PhpPages\Template;

use PhpPages\TemplateInterface;

class LayoutTemplate implements TemplateInterface
{
    private string $file;

    function __construct(string $file)
    {
        $this->file = $file;    
    }

    function content(array $params = []): string
    {
        ob_start();
        include($this->file);
        $content = ob_get_contents();
        ob_end_clean();

        return $content;
    }
}