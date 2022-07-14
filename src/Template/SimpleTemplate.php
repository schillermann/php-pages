<?php
namespace PhpPages\Template;

use PhpPages\TemplateInterface;

class SimpleTemplate implements TemplateInterface
{
    private string $filePath;
    private array $params;
    
    function __construct(
        string $filePath,
        array $params = []
    ) {
        $this->filePath = $filePath;
        $this->params = $params;
    }

    function content(): string
    {
        foreach ($this->params as $name => $value) {
            ${$name} = $value;
        }

        ob_start();
        include($this->filePath);
        $content = ob_get_contents();
        ob_end_clean();

        return $content;
    }

    function withParam(string $name, $value): TemplateInterface
    {
        $this->params[$name] = $value;

        return new SimpleTemplate(
            $this->filePath,
            $this->params
        );
    }
}