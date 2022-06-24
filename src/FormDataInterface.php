<?php
namespace PhpPages;

interface FormDataInterface
{
    function param(string $name): string;
}