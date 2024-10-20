<?php

namespace PhpPages\Tests;

use PhpPages\Page\Request\ConstraintNotBlank;
use PHPUnit\Framework\TestCase;

class ConstraintNotBlankTest extends TestCase
{
    function testRequiredPropertyIsSet(): void
    {
        $constraintNotBlank = new ConstraintNotBlank();
        $constraintNotBlank->check('property', 'value');

        $this->assertFalse($constraintNotBlank->hasError());
        $this->assertEmpty($constraintNotBlank->error());
    }

    function testRequiredPropertyIsNotSet(): void
    {
        $constraintNotBlank = new ConstraintNotBlank();
        $constraintNotBlank->check('property', '');

        $this->assertTrue($constraintNotBlank->hasError());
        $this->assertEquals(
            "Property 'property' is required.",
            $constraintNotBlank->error()
        );
    }
}
