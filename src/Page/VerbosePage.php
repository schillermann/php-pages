<?php
namespace PhpPages\Page;

use PhpPages\OutputInterface;
use PhpPages\PageInterface;

class VerbosePage implements PageInterface
{
    private array $args;

    function __construct()
    {
        $this->args = [];    
    }

    function page(string $name, string $value): PageInterface
    {
        $this->args[] = $name . ': ' . $value;
        return $this;
    }

    function output(OutputInterface $output): OutputInterface
    {
        return (new TextPage(
            implode(PHP_EOL, $this->args)
        ))->output($output);
    }
}