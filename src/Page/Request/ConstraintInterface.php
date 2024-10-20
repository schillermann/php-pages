<?php

namespace PhpPages\Page\Request;

interface ConstraintInterface
{
    function check(string $propertyName, $propertyValue): void;

    function error(): string;

    function hasError(): bool;
}
