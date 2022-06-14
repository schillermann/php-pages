<?php
namespace PhpPages;

class App
{
    private PageInterface $page;

    function __construct(PageInterface $page)
    {
        $this->page = $page;
    }

    function process(RequestInterface $request, ResponseInterface $response)
    {
        (new Session($this->page))
            ->with($request)
            ->via(new SimpleOutput())
            ->print($response);
    }
}