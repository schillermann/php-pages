<?php
namespace PhpPages;

interface PageLayoutInterface extends PageInterface
{
    function withPage(PageInterface $page): PageLayoutInterface;
}