<?php
namespace PhpPages;

interface TemplateInterface
{
    function content(): string;

    function withLayout(TemplateInterface $template, string $placeholder): TemplateInterface;
}