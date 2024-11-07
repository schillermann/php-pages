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

    function testBooleanType(): void
    {
        $constraintType = new ConstraintType(ConstraintType::TYPE_BOOLEAN);
        $constraintType->check('property', true);

        $this->assertFalse($constraintType->hasError());
        $this->assertEmpty($constraintType->error());
    }

    function testWrongBooleanType(): void
    {
        $constraintType = new ConstraintType(ConstraintType::TYPE_BOOLEAN);
        $constraintType->check('property', 10);

        $this->assertTrue($constraintType->hasError());
        $this->assertEquals("Property 'property' is not a boolean.", $constraintType->error());
    }

    function testIntegerType(): void
    {
        $constraintType = new ConstraintType(ConstraintType::TYPE_INTEGER);
        $constraintType->check('property', 10);

        $this->assertFalse($constraintType->hasError());
        $this->assertEmpty($constraintType->error());
    }

    function testWrongIntegerType(): void
    {
        $constraintType = new ConstraintType(ConstraintType::TYPE_INTEGER);
        $constraintType->check('property', 'value');

        $this->assertTrue($constraintType->hasError());
        $this->assertEquals("Property 'property' is not an integer.", $constraintType->error());
    }

    function testFloatType(): void
    {
        $constraintType = new ConstraintType(ConstraintType::TYPE_FLOAT);
        $constraintType->check('property', 5.1);

        $this->assertFalse($constraintType->hasError());
        $this->assertEmpty($constraintType->error());
    }

    function testWrongFloatType(): void
    {
        $constraintType = new ConstraintType(ConstraintType::TYPE_FLOAT);
        $constraintType->check('property', 10);

        $this->assertTrue($constraintType->hasError());
        $this->assertEquals("Property 'property' is not a float.", $constraintType->error());
    }

    function testNumericType(): void
    {
        $constraintType = new ConstraintType(ConstraintType::TYPE_NUMERIC);
        $constraintType->check('property', "42");

        $this->assertFalse($constraintType->hasError());
        $this->assertEmpty($constraintType->error());

        $constraintType = new ConstraintType(ConstraintType::TYPE_NUMERIC);
        $constraintType->check('property', 1337);

        $this->assertFalse($constraintType->hasError());
        $this->assertEmpty($constraintType->error());

        $constraintType = new ConstraintType(ConstraintType::TYPE_NUMERIC);
        $constraintType->check('property', 0x539);

        $this->assertFalse($constraintType->hasError());
        $this->assertEmpty($constraintType->error());

        $constraintType = new ConstraintType(ConstraintType::TYPE_NUMERIC);
        $constraintType->check('property', 0b10100111001);

        $this->assertFalse($constraintType->hasError());
        $this->assertEmpty($constraintType->error());

        $constraintType = new ConstraintType(ConstraintType::TYPE_NUMERIC);
        $constraintType->check('property', 1337e0);

        $this->assertFalse($constraintType->hasError());
        $this->assertEmpty($constraintType->error());

        $constraintType = new ConstraintType(ConstraintType::TYPE_NUMERIC);
        $constraintType->check('property', 9.1);

        $this->assertFalse($constraintType->hasError());
        $this->assertEmpty($constraintType->error());
    }

    function testWrongNumericType(): void
    {
        $constraintType = new ConstraintType(ConstraintType::TYPE_NUMERIC);
        $constraintType->check('property', '0x539');

        $this->assertTrue($constraintType->hasError());
        $this->assertEquals("Property 'property' is not a numeric.", $constraintType->error());

        $constraintType = new ConstraintType(ConstraintType::TYPE_NUMERIC);
        $constraintType->check('property', '0b10100111001');

        $this->assertTrue($constraintType->hasError());
        $this->assertEquals("Property 'property' is not a numeric.", $constraintType->error());

        $constraintType = new ConstraintType(ConstraintType::TYPE_NUMERIC);
        $constraintType->check('property', 'not numeric');

        $this->assertTrue($constraintType->hasError());
        $this->assertEquals("Property 'property' is not a numeric.", $constraintType->error());

        $constraintType = new ConstraintType(ConstraintType::TYPE_NUMERIC);
        $constraintType->check('property', []);

        $this->assertTrue($constraintType->hasError());
        $this->assertEquals("Property 'property' is not a numeric.", $constraintType->error());

        $constraintType = new ConstraintType(ConstraintType::TYPE_NUMERIC);
        $constraintType->check('property', null);

        $this->assertTrue($constraintType->hasError());
        $this->assertEquals("Property 'property' is not a numeric.", $constraintType->error());

        $constraintType = new ConstraintType(ConstraintType::TYPE_NUMERIC);
        $constraintType->check('property', '');

        $this->assertTrue($constraintType->hasError());
        $this->assertEquals("Property 'property' is not a numeric.", $constraintType->error());
    }

    function testUnknownType(): void
    {
        $constraintType = new ConstraintType('unknown');
        $constraintType->check('property', 'value');

        $this->assertTrue($constraintType->hasError());
        $this->assertEquals("Property 'property' has an unknown type.", $constraintType->error());
    }
}
