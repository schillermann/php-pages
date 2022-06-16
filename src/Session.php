<?php
namespace PhpPages;

class Session
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
            ->page('PhpPages-Method', $request->method())
            ->page('PhpPages-Path', $path)
            ->page('PhpPages-Query', $query)
            ->page('PhpPages-Protocol', $request->protocol());

        foreach ($request->head() as $name => $value) {
            $page = $page->page($name, $value);
        }

        if ($request->body()) {
            $page = $page->page('PhpPages-Body', $request->body());
        }

        return $page;
    }
}