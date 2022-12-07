<?php
namespace PhpPages;

interface TemplateInterface
{
    public function __toString(): string;

    public function withParameter(string $name, $value): TemplateInterface;
}