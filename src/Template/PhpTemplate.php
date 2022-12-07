<?php
namespace PhpPages\Template;

use PhpPages\TemplateInterface;

class PhpTemplate implements TemplateInterface
{
    private string $filePath;
    private array $parameters;

    public function __construct(string $filePath, array $parameters = [])
    {
        $this->filePath = $filePath;
        $this->parameters = $parameters;
    }

    public function __toString(): string
    {
        foreach ($this->parameters as $name => $value) {
            ${$name} = $value;
        }

        ob_start();
        include($this->filePath);
        $content = ob_get_contents();
        ob_end_clean();

        return $content;
    }

    public function withParameter(string $name, $value): TemplateInterface
    {
        $this->parameters[$name] = $value;

        return new self(
            $this->filePath,
            $this->parameters
        );
    }
}