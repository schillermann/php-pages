<?php
namespace PhpPages;

interface PageWithRoutesInterface extends PageInterface
{
    function withRoute(string $route, PageInterface $page): PageWithRoutesInterface;
}