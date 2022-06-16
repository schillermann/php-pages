<?php
namespace PhpPages;

class App
{
    private PageInterface $page;

    function __construct(PageInterface $page)
    {
        $this->page = $page;
    }

    function process(RequestInterface $request, ResponseInterface $response): void
    {
        (new Session($this->page))
            ->page($request)
            ->output(new SimpleOutput())
            ->write($response);
    }
}