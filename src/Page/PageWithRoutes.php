<?php
namespace PhpPages\Page;

use PhpPages\OutputInterface;
use PhpPages\PageInterface;
use PhpPages\PageWithRoutesInterface;

class PageWithRoutes implements PageWithRoutesInterface
{
    private PageInterface $fallback;
    private array $routesWithPage;

    function __construct(PageInterface $fallback, array $routesWithPage = [])
    {
        $this->fallback = $fallback;
        $this->routesWithPage = $routesWithPage;
    }
    
    function viaOutput(OutputInterface $output): OutputInterface
    {
        return $output;
    }

    function withMetadata(string $name, string $value): PageInterface
    {
        if ($name === 'PhpPages-Path') {

            if (array_key_exists($value, $this->routesWithPage)) {
                return $this->routesWithPage[$value]->withMetadata($name, $value);
            }

            return $this->fallback->withMetadata($name, $value);
        }
        return $this;
    }

    public function withRoute(string $route, PageInterface $page): PageWithRoutesInterface
    {
        $this->routesWithPage[$route] = $page;

        return new PageWithRoutes(
            $this->fallback,
            $this->routesWithPage
        );
    }
}