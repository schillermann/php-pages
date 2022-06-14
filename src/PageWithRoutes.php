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
    
    function metadata(string $name, string $value): PageInterface
    {
        if ($name === 'PhpPages-Path') {
            if ($value === $this->path) {
                return $this->origin->metadata($name, $value);
            }
            return $this->fallback->metadata($name, $value);
        }
        return $this;
    }

    function via(OutputInterface $output): OutputInterface
    {
        return $output;
    }
}