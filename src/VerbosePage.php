<?php
namespace PhpPages;

class VerbosePage implements PageInterface
{
    private array $args;

    function __construct()
    {
        $this->args = [];    
    }

    function metadata(string $name, string $value): PageInterface
    {
        $this->args[] = $name . ': ' . $value;
        return $this;
    }

    function via(OutputInterface $output): OutputInterface
    {
        return (new TextPage(
            implode(PHP_EOL, $this->args)
        ))->via($output);
    }
}