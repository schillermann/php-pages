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

    function withPropertyConstraints(string $name, ConstraintInterface ...$constraints): self
    {
        $properties = $this->properties;
        $properties[$name] = $constraints;

        return new self($properties);
    }

    function withPropertyObject(string $name, RequestConstraints $object)
    {
        $properties = $this->properties;
        $properties[$name] = $object;

        return new self($properties);
    }

    function check(array $body): void
    {
        $errors = [];

        foreach ($this->properties as $propertyKey => $propertyConstraintsOrObject) {
            if ($propertyConstraintsOrObject instanceof RequestConstraints) {
                $propertyConstraintsOrObject->check($body[$propertyKey]);
                $errors = array_merge($errors, $propertyConstraintsOrObject->errors());
                continue;
            }

            foreach ($propertyConstraintsOrObject as $propertyConstraint) {
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
