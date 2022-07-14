<?php
namespace PhpPages;

interface LanguageInterface
{
    function translation(string $text, ...$values): string;
}