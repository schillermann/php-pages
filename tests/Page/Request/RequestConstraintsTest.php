<?php

namespace PhpPages\Tests;

use PhpPages\Page\Request\ConstraintNotBlank;
use PhpPages\Page\Request\ConstraintType;
use PhpPages\Page\Request\RequestConstraints;
use PHPUnit\Framework\TestCase;

class RequestConstraintsTest extends TestCase
{
    function testRequiredPropertyExists(): void
    {
        $requestConstraints = (new RequestConstraints())
            ->withPropertyConstraints(
                'property',
                new ConstraintNotBlank(),
                new ConstraintType(ConstraintType::TYPE_STRING)
            );

        $requestConstraints->check(['property' => 'value']);

        $this->assertFalse($requestConstraints->hasErrors());
        $this->assertEmpty($requestConstraints->errors());
    }

    function testRequiredPropertyNotExists(): void
    {
        $requestConstraints = (new RequestConstraints())
            ->withPropertyConstraints(
                'property',
                new ConstraintNotBlank(),
                new ConstraintType(ConstraintType::TYPE_STRING)
            );

        $requestConstraints->check([]);

        $this->assertTrue($requestConstraints->hasErrors());
        $this->assertEquals(["Property 'property' is required."], $requestConstraints->errors());
    }

    function testNestedPropertyObject(): void
    {
        $requestConstraintsAddress = (new RequestConstraints())
            ->withPropertyConstraints(
                'street',
                new ConstraintNotBlank(),
                new ConstraintType(ConstraintType::TYPE_STRING)
            );

        $requestConstraintsPerson = (new RequestConstraints())
        ->withPropertyConstraints(
            'name',
            new ConstraintNotBlank(),
            new ConstraintType(ConstraintType::TYPE_STRING)
        )
            ->withPropertyObject('address', $requestConstraintsAddress);

        $requestConstraintsPerson->check([
            'name' => 'John Doe',
            'address' => [
                'street' => '123 Maple Street. Anytown, PA 17101'
            ]
        ]);

        $this->assertFalse($requestConstraintsPerson->hasErrors());
        $this->assertEmpty($requestConstraintsPerson->errors());
    }

    function testNestedRequiredPropertyNotExists(): void
    {
        $requestConstraintsAddress = (new RequestConstraints())
            ->withPropertyConstraints(
                'street',
                new ConstraintNotBlank(),
                new ConstraintType(ConstraintType::TYPE_STRING)
            );

        $requestConstraintsPerson = (new RequestConstraints())
        ->withPropertyConstraints(
            'name',
            new ConstraintNotBlank(),
            new ConstraintType(ConstraintType::TYPE_STRING)
        )
            ->withPropertyObject('address', $requestConstraintsAddress);

        $requestConstraintsPerson->check([
            'address' => []
        ]);

        $this->assertTrue($requestConstraintsPerson->hasErrors());
        $this->assertEquals(
            [
            "Property 'name' is required.",
            "Property 'street' is required."
            ],
            $requestConstraintsPerson->errors()
        );
    }
}
