<?php
namespace PhpPages\Page;

use PhpPages\OutputInterface;
use PhpPages\PageInterface;

class RedirectPage implements PageInterface
{
    private string $location;
    private bool $movedPermanently;

    function __construct(string $location, bool $movedPermanently = false)
    {
        $this->location = $location;
        $this->movedPermanently = $movedPermanently;
    }

    public function viaOutput(OutputInterface $output): OutputInterface
    {
        if ($this->movedPermanently) {
            $output = $output->withMetadata('PhpPages-HttpStatus', 'HTTP/1.1 301 Moved Permanently');
        } else {
            $output = $output->withMetadata('PhpPages-HttpStatus', 'HTTP/1.1 302 Found');
        }
        return $output->withMetadata('Location', $this->location);
    }

    public function withMetadata(string $name, string $value): PageInterface
    {
        return $this;
    }
}