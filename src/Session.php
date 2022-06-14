<?php
namespace PhpPages;

class Session
{
    private PageInterface $page;

    function __construct(PageInterface $page)
    {
        $this->page = $page;
    }

    function with(RequestInterface $request): PageInterface
    {
        $requestUri = explode('?', $request->uri());
        $path = $requestUri[0];
        $query = (array_key_exists(1, $requestUri))? $requestUri[1] : '';
        
        $pageWithMetadata = $this->page;
        $pageWithMetadata = $pageWithMetadata->metadata('PhpPages-Method', $request->method());
        $pageWithMetadata = $pageWithMetadata->metadata('PhpPages-Path', $path);
        $pageWithMetadata = $pageWithMetadata->metadata('PhpPages-Query', $query);
        $pageWithMetadata = $pageWithMetadata->metadata('PhpPages-Protocol', $request->protocol());

        foreach ($request->head() as $name => $value) {
            $pageWithMetadata = $pageWithMetadata->metadata($name, $value);
        }

        if ($request->body()) {
            $pageWithMetadata = $pageWithMetadata->metadata('PhpPages-Body', $request->body());
        }

        return $pageWithMetadata;
    }
}