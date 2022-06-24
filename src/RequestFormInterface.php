<?php
namespace PhpPages;

interface RequestFormInterface extends RequestInterface
{
    function param(string $key): string;
}