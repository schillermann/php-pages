<?php
namespace PhpPages\Template;

use PhpPages\TemplateInterface;

class SimpleTemplate implements TemplateInterface
{
    private string $filePath;
    private array $params;
    private string $head;
    private string $foot;
    
    function __construct(
        string $filePath,
        array $params = [],
        string $head = '',
        string $foot = ''
    ) {
        $this->filePath = $filePath;
        $this->params = $params;
        $this->head = $head;
        $this->foot = $foot;
    }

    function content(): string
    {
        ob_start();
        include($this->filePath);
        $content = ob_get_contents();
        ob_end_clean();

        return $this->head . $content . $this->foot;
    }

    function withLayout(TemplateInterface $template, string $placeholder): TemplateInterface
    {
        $templateSplit = explode($placeholder, $template->content());
        if (count($templateSplit) < 2) {
            throw new \InvalidArgumentException('Placeholder "' . $placeholder . '" could not be found in template "' . $this->filePath . '"');
        }
        return new SimpleTemplate(
            $this->filePath,
            $this->params,
            $templateSplit[0],
            $templateSplit[1]
        );
    }
}