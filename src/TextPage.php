<?php
namespace PhpPages;

class TextPage implements PageInterface
{
    private string $body;

    function __construct(string $text)
    {
        $this->body = $text;    
    }

    function metadata(string $name, string $value): PageInterface
    {
        return $this;
    }

    function via(OutputInterface $output): OutputInterface
    {
        return $output
            ->metadata('Content-Type', 'text/plain')
            ->metadata('Content-Length', strlen($this->body))
            ->metadata('PhpPages-Body', $this->body);
    }
}