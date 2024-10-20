<?php

namespace PhpPages\Tests;

use PhpPages\Page\Request\ConstraintType;
use PHPUnit\Framework\TestCase;

class ConstraintTypeTest extends TestCase
{
    function testStringType(): void
    {
        $constraintType = new ConstraintType(ConstraintType::TYPE_STRING);
        $constraintType->check('property', 'value');

        $this->assertFalse($constraintType->hasError());
        $this->assertEmpty($constraintType->error());
    }

    function testWrongStringType(): void
    {
        $constraintType = new ConstraintType(ConstraintType::TYPE_STRING);
        $constraintType->check('property', 10);

        $this->assertTrue($constraintType->hasError());
        $this->assertEquals("Property 'property' is not a string.", $constraintType->error());
    }

    function testUnkownStringType(): void
    {
        $constraintType = new ConstraintType('unkown');
        $constraintType->check('property', 'value');

        $this->assertTrue($constraintType->hasError());
        $this->assertEquals("Property 'property' has an unknown type.", $constraintType->error());
    }
}
