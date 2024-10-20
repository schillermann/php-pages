<?php

namespace PhpPages\Page\Request;

class ConstraintType implements ConstraintInterface
{
    const TYPE_STRING = 'string';

    private string $error;
    function __construct(private string $type)
    {
        $this->error = '';
    }

    function check(string $propertyName, $propertyValue): void
    {
        if ($this->type === self::TYPE_STRING) {
            $this->error = is_string($propertyValue) ? '' : sprintf("Property '%s' is not a %s.", $propertyName, self::TYPE_STRING);
            return;
        }
        $this->error = sprintf("Property '%s' has an unknown type.", $propertyName);
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
