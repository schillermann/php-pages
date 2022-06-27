<?php
namespace PhpPages\Template;

use PhpPages\TemplateInterface;

class SimpleTemplate implements TemplateInterface
{
    private string $filePath;
    
    function __construct(
        string $filePath
    ) {
        $this->filePath = $filePath;
    }

    function content(array $params = []): string
    {
        ob_start();
        include($this->filePath);
        $content = ob_get_contents();
        ob_end_clean();

        return $content;
    }
}