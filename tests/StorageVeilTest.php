<?php
namespace PhpPages\Tests;

use PhpPages\StorageVeil;
use PHPUnit\Framework\TestCase;

class Dummy
{
    function name(): string
    {
        return 'Origin Name';
    }

    function save(): void {}
}

class StorageVeilTest extends TestCase
{
    function testCanGetNameOfVeil(): void
    {
        $dummy = new StorageVeil(
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
        $dummy = new StorageVeil(
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