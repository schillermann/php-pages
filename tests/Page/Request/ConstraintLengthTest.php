<?php

namespace PhpPages\Tests;

use PhpPages\Page\Request\ConstraintLength;
use PHPUnit\Framework\TestCase;

class ConstraintLengthTest extends TestCase
{
    function testPropertyValueWithMinAndMaxLength(): void
    {
        $constraintLength = new ConstraintLength(1, 5);
        $constraintLength->check('property', 'value');

        $this->assertFalse($constraintLength->hasError());
        $this->assertEmpty($constraintLength->error());
    }

    function testPropertyValueWithoutMinAndMaxLength(): void
    {
        $constraintLength = new ConstraintLength();
        $constraintLength->check('property', 'value');

        $this->assertFalse($constraintLength->hasError());
        $this->assertEmpty($constraintLength->error());
    }

    function testShortPropertyValue(): void
    {
        $constraintLength = new ConstraintLength(10);
        $constraintLength->check('property', 'value');

        $this->assertTrue($constraintLength->hasError());
        $this->assertEquals(
            "Property 'property' is shorter than 10 characters.",
            $constraintLength->error()
        );
    }

    function testLongPropertyValue(): void
    {
        $constraintLength = new ConstraintLength(0, 4);
        $constraintLength->check('property', 'value');

        $this->assertTrue($constraintLength->hasError());
        $this->assertEquals(
            "Property 'property' is longer than 4 characters.",
            $constraintLength->error()
        );
    }
}
