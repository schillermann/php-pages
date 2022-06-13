<?php
namespace PhpPages\Tests;

use PhpPages\SimpleOutput;
use PHPUnit\Framework\TestCase;

class OutputTest extends TestCase
{
    function testCanGetOutputAsString(): void
    {
        $actual = (new SimpleOutput())
            ->metadata('Content-Length', 12)
            ->metadata('Content-Type', 'text/plain')
            ->metadata('PhpPages-Body', 'Hello World!')
            ->__toString();

        $expected = <<<RESPONSE
HTTP/1.1 200 OK
Content-Length: 12
Content-Type: text/plain

Hello World!
RESPONSE;

        $this->assertEquals(
            $expected,
            $actual
        );
    }
}