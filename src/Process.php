<?php
namespace PhpPages;

use PhpPages\PageInterface;
use PhpPages\RequestInterface;

class Process
{
    private PageInterface $page;

    function __construct(PageInterface $page)
    {
        $this->page = $page;
    }

    function page(RequestInterface $request): PageInterface
    {
        $requestUri = explode('?', $request->uri());
        $path = $requestUri[0];
        $query = (array_key_exists(1, $requestUri))? $requestUri[1] : '';
        
        $page = (clone $this->page)
            ->withMetadata('PhpPages-Method', $request->method())
            ->withMetadata('PhpPages-Path', $path)
            ->withMetadata('PhpPages-Query', $query)
            ->withMetadata('PhpPages-Protocol', $request->protocol());

        foreach ($request->head() as $name => $value) {
            $page = $page->withMetadata($name, $value);
        }

        return $page->withMetadata('PhpPages-Body', $request->body());
    }
}