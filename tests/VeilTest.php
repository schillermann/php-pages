<?php
namespace PhpPages\Tests;

use PhpPages\Veil;
use PHPUnit\Framework\TestCase;

class Dummy
{
    function name(): string
    {
        return 'Origin Name';
    }

    function save(): void {}
}

class VeilTest extends TestCase
{
    function testCanGetNameOfVeil(): void
    {
        $dummy = new Veil(
            new Dummy(),
            ['name' => 'New Name']
        );

        $this->assertEquals(
            'New Name',
            $dummy->name()
        );
    }

    function testCanVeilBePierced(): void
    {
        $dummy = new Veil(
            new Dummy(),
            ['name' => 'New Name']
        );
        $dummy->save();

        $this->assertEquals(
            'Origin Name',
            $dummy->name()
        );
    }
}