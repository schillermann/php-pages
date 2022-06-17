<?php
namespace PhpPages;

interface TemplateInterface
{
    function content(array $placeholders = []): string;
}