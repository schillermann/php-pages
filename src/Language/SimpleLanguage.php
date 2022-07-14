<?php
namespace PhpPages\Language;

use PhpPages\LanguageInterface;

class SimpleLanguage implements LanguageInterface
{
    private string $filePath;

    function __construct($filePath)
    {
        $this->filePath = $filePath;
    }

    function translation(string $text, ...$values): string
    {
        $translation = include($this->filePath);

        if ( array_key_exists($text, $translation) ) {
            return vsprintf(
                $translation[$text],
                $values
            );
        }

        return vsprintf(
            $text,
            $values
        );
    }
}