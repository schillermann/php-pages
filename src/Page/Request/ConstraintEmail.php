<?php

namespace PhpPages\Page\Request;

class ConstraintEmail implements ConstraintInterface
{
    private string $error;

    function __construct()
    {
        $this->error = '';
    }

    function check(string $propertyName, $propertyValue): void
    {
        if (filter_var($propertyValue, FILTER_VALIDATE_EMAIL) === false) {
            $this->error = "Property '{$propertyName}' has an invalid email.";
        }
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
