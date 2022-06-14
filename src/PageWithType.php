<?php
namespace PhpPages;

class PageWithType implements PageInterface
{
    private PageInterface $origin;
    private string $contentType;

    function __construct(PageInterface $origin, string $contentType)
    {
        $this->origin = $origin;
        $this->contentType = $contentType;
    }

    function metadata(string $name, string $value): PageInterface
    {
        return $this;
    }

    function via(OutputInterface $output): OutputInterface
    {
        return $this->origin->via(
            $output->metadata('Content-Type', $this->contentType)
        );
    }
}