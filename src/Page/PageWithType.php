<?php
namespace PhpPages\Page;

use PhpPages\OutputInterface;
use PhpPages\PageInterface;

class PageWithType implements PageInterface
{
    private PageInterface $origin;
    private string $contentType;

    function __construct(PageInterface $origin, string $contentType)
    {
        $this->origin = $origin;
        $this->contentType = $contentType;
    }

    function page(string $name, string $value): PageInterface
    {
        return $this;
    }

    function output(OutputInterface $output): OutputInterface
    {
        return $this->origin->output(
            $output->output('Content-Type', $this->contentType)
        );
    }
}