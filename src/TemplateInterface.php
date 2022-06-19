<?php
namespace PhpPages;

interface TemplateInterface
{
    function content(array $params = []): string;
}