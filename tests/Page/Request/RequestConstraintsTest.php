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
            ->withProperty(
                'property',
                new ConstraintNotBlank(),
                new ConstraintType('string')
            );

        $requestConstraints->check(['property' => 'value']);

        $this->assertFalse($requestConstraints->hasErrors());
        $this->assertEmpty($requestConstraints->errors());
    }

    function testRequiredPropertyNotExists(): void
    {
        $requestConstraints = (new RequestConstraints())
            ->withProperty(
                'property',
                new ConstraintNotBlank(),
                new ConstraintType('string')
            );

        $requestConstraints->check([]);

        $this->assertTrue($requestConstraints->hasErrors());
        $this->assertEquals(["Property 'property' is required."], $requestConstraints->errors());
    }
}
