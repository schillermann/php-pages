<?php

namespace PhpPages\Tests;

use PhpPages\Page\Request\ConstraintEmail;
use PHPUnit\Framework\TestCase;

class ConstraintEmailTest extends TestCase
{
    function testValidEmail(): void
    {
        $constraintEmail = new ConstraintEmail();
        $constraintEmail->check('property', 'my@email.org');

        $this->assertFalse($constraintEmail->hasError());
        $this->assertEmpty($constraintEmail->error());
    }

    function testInvalidEmail(): void
    {
        $constraintEmail = new ConstraintEmail();
        $constraintEmail->check('property', 'value');

        $this->assertTrue($constraintEmail->hasError());
        $this->assertEquals("Property 'property' has an invalid email.", $constraintEmail->error());
    }
}
