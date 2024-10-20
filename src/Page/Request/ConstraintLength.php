<?php

namespace PhpPages\Page\Request;

class ConstraintLength implements ConstraintInterface
{
    private string $error;

    function __construct(private int $min = 0, private int $max = 0)
    {
        $this->error = '';
    }

    function check(string $propertyName, $propertyValue): void
    {
        $stringLength = strlen($propertyValue);

        if ($this->max > 0 && $this->max < $stringLength) {
            $this->error = "Property '{$propertyName}' is longer than {$this->max} characters.";
        } elseif ($this->min > 0 && $this->min > $stringLength) {
            $this->error = "Property '{$propertyName}' is shorter than {$this->min} characters.";
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
