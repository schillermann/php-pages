<?php

namespace PhpPages\Page\Request;

class ConstraintNotBlank implements ConstraintInterface
{
    private string $error;
    function __construct()
    {
        $this->error = '';
    }

    function check(string $propertyName, $propertyValue): void
    {
        $this->error = ($propertyValue) ? '' : "Property '{$propertyName}' is required.";
    }

    function error(): string
    {
        return $this->error;
    }

    function hasError(): bool
    {
        return !empty($this->error);
    }
}
