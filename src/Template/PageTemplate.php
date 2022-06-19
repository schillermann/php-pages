<?php
namespace PhpPages\Template;

use PhpPages\TemplateInterface;

class PageTemplate implements TemplateInterface
{
    private TemplateInterface $origin;
    private string $file;
    private string $placeholder;

    function __construct(TemplateInterface $origin, string $file, string $placeholder)
    {
        $this->origin = $origin;
        $this->file = $file;
        $this->placeholder = $placeholder;
    }

    function content(array $params = []): string
    {
        $originContent = $this->origin->content($params);
        ob_start();
        include($this->file);
        $content = ob_get_contents();
        ob_end_clean();

        return str_replace($this->placeholder, $content, $originContent);
    }
}