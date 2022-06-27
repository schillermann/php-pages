<?php
namespace PhpPages;

use PhpPages\Request\NativeRequest;
use PhpPages\Response\NativeResponse;

class App
{
    private PageInterface $page;

    function __construct(PageInterface $page)
    {
        $this->page = $page;
    }

    function start(): void
    {
        (new Process($this->page))
            ->page(new NativeRequest())
            ->viaOutput(new SimpleOutput())
            ->writeTo(new NativeResponse());
    }
}