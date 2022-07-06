<?php
namespace PhpPages;

class App
{
    private PageInterface $page;

    function __construct(PageInterface $page)
    {
        $this->page = $page;
    }

    function start(RequestInterface $request, ResponseInterface $response): void
    {
        (new Process($this->page))
            ->page($request)
            ->viaOutput(new SimpleOutput())
            ->writeTo($response);
    }
}