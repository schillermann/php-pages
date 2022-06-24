<?php
namespace PhpPages\Page;

use PhpPages\OutputInterface;
use PhpPages\PageInterface;

class SimplePage implements PageInterface
{
    private string $body;

    function __construct(string $text)
    {
        $this->body = $text;    
    }

    function viaOutput(OutputInterface $output): OutputInterface
    {
        return $output
            ->withMetadata('Content-Length', strlen($this->body))
            ->withMetadata('PhpPages-Body', $this->body);
    }

    function withMetadata(string $name, string $value): PageInterface
    {
        return $this;
    }
}