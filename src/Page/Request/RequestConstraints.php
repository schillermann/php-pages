<?php

namespace PhpPages\Page\Request;

use PhpPages\Page\Request\ConstraintInterface;

class RequestConstraints
{
    private array $errors;

    function __construct(private array $properties = [])
    {
        $this->errors = [];
    }

    function withProperty(string $name, ConstraintInterface ...$constraints): self
    {
        $properties = $this->properties;
        $properties[$name] = $constraints;

        return new self($properties);
    }

    function check(array $body): void
    {
        $errors = [];

        foreach ($this->properties as $propertyKey => $propertyConstraints) {
            foreach ($propertyConstraints as $propertyConstraint) {
                $propertyConstraint->check(
                    $propertyKey,
                    isset($body[$propertyKey]) ? $body[$propertyKey] : null
                );

                $errors[] = $propertyConstraint->error();
                if ($propertyConstraint->hasError() && $propertyConstraint instanceof ConstraintNotBlank) {
                    break;
                }
            }
        }
        $this->errors = array_filter($errors);
    }

    function errors(): array
    {
        return $this->errors;
    }

    function hasErrors(): bool
    {
        return !empty($this->errors);
    }
}
