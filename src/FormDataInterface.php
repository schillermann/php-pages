<?php
namespace PhpPages;

interface FormDataInterface
{
    function exists(string $name): bool;

    function param(string $name): string;

    function paramWithDefault(string $name, string $defaultValue): string;
}