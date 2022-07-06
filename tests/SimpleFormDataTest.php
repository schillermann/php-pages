<?php
namespace PhpPages\Tests;

use PhpPages\Form\SimpleFormData;
use PHPUnit\Framework\TestCase;

class SimpleFormDataTest extends TestCase
{
    function testCanGetParam(): void
    {
        $expected = 'müll=trash';
        $form = new SimpleFormData(
            'type=' . urlencode($expected) . '&color=' . urlencode('red&green')
        );

        $this->assertEquals(
            $expected,
            $form->param('type')
        );
    }

    function testKeyParamNotFound(): void
    {
        $this->assertEmpty(
            (new SimpleFormData(''))->param('no-param')
        );
    }
}