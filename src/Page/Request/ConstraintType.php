<?php

namespace PhpPages\Page\Request;

class ConstraintType implements ConstraintInterface
{
    const TYPE_STRING = 'string';
    const TYPE_BOOLEAN = 'boolean';
    const TYPE_INTEGER = 'integer';
    const TYPE_FLOAT = 'float';
    const TYPE_NUMERIC = 'numeric';

    private string $error;
    function __construct(private string $type)
    {
        $this->error = '';
    }

    function check(string $propertyName, $propertyValue): void
    {
        if (self::TYPE_STRING === $this->type) {
            $this->error = is_string($propertyValue) ? '' : sprintf("Property '%s' is not a string.", $propertyName);
            return;
        }
        if (self::TYPE_BOOLEAN === $this->type) {
            $this->error = is_bool($propertyValue) ? '' : sprintf("Property '%s' is not a boolean.", $propertyName);
            return;
        }
        if (self::TYPE_INTEGER === $this->type) {
            $this->error = is_integer($propertyValue) ? '' : sprintf("Property '%s' is not an integer.", $propertyName);
            return;
        }
        if (self::TYPE_FLOAT === $this->type) {
            $this->error = is_float($propertyValue) ? '' : sprintf("Property '%s' is not a float.", $propertyName);
            return;
        }
        if (self::TYPE_NUMERIC === $this->type) {
            $this->error = is_numeric($propertyValue) ? '' : sprintf("Property '%s' is not a numeric.", $propertyName);
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
