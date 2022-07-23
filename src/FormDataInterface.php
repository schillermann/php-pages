<?php
namespace PhpPages;

interface FormDataInterface
{
    function exists(string $name): bool;

    function param(string $name): string;
}