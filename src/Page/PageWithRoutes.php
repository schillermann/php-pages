<?php
namespace PhpPages\Page;

use PhpPages\OutputInterface;
use PhpPages\PageInterface;

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
    
    function viaOutput(OutputInterface $output): OutputInterface
    {
        return $output;
    }

    function withMetadata(string $name, string $value): PageInterface
    {
        if ($name === 'PhpPages-Path') {
            if ($value === $this->path) {
                return $this->origin->withMetadata($name, $value);
            }
            return $this->fallback->withMetadata($name, $value);
        }
        return $this;
    }
}