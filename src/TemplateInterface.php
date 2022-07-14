<?php
namespace PhpPages;

interface TemplateInterface
{
    function content(): string;

    function withParam(string $name, $value): TemplateInterface;
}