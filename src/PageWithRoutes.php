<?php
namespace PhpPages;

class PageWithRoutes implements PageInterface
{
    private string $path;
    private PageInterface $origin;
    private PageInterface $fallback;

    function __construct(string $path, PageInterface $origin, PageInterface $fallback)
    {
        $this->path = $path;
        $this->origin = $origin;
        $this->fallback = $fallback;
    }
    
    function page(string $name, string $value): PageInterface
    {
        if ($name === 'PhpPages-Path') {
            if ($value === $this->path) {
                return $this->origin->page($name, $value);
            }
            return $this->fallback->page($name, $value);
        }
        return $this;
    }

    function output(OutputInterface $output): OutputInterface
    {
        return $output;
    }
}