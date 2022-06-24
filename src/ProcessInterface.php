<?php
namespace PhpPages;

interface ProcessInterface
{
    function page(RequestInterface $request): PageInterface;
}