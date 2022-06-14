<?php
namespace PhpPages;

interface ResponseInterface
{
    function head(string $head): void;

    function body(string $body): void;
}