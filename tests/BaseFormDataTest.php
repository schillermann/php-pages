<?php
namespace PhpPages\Tests;

use PhpPages\Form\BaseFormData;
use PHPUnit\Framework\TestCase;

class BaseFormDataTest extends TestCase
{
    function testCanGetParam(): void
    {
        $expected = 'müll=trash';
        $form = new BaseFormData(
            'type=' . urlencode($expected) . '&color=' . urlencode('red&green')
        );

        $this->assertEquals(
            $expected,
            $form->param('type')
        );
    }

    function testKeyParamNotFound(): void
    {
        $this->expectException(\OutOfRangeException::class);

        (new BaseFormData(''))->param('no-param');
    }
}