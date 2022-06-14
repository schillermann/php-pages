<?php
namespace PhpPages;

interface RequestInterface
{
    function body(): string;

    function head(): array;

    function method(): string;

    function protocol(): string;

    function uri(): string;
}