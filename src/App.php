<?php
namespace PhpPages;

class App
{
    private PageInterface $page;
    private OutputInterface $output;

    function __construct(PageInterface $page, OutputInterface $output)
    {
        $this->page = $page;
        $this->output = $output;
    }

    function process(RequestInterface $request, ResponseInterface $response): void
    {
        (new Session($this->page))
            ->page($request)
            ->output($this->output)
            ->write($response);
    }
}