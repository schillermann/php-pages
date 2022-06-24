<?php
namespace PhpPages\Tests;

use PhpPages\Output\BaseOutput;
use PhpPages\Page\VerbosePage;
use PhpPages\Process\BaseProcess;
use PhpPages\Request\FakeRequest;
use PHPUnit\Framework\TestCase;

class BaseProcessTest extends TestCase
{
    function testCanGetOutput(): void
    {
        $response = (new BaseProcess(
                new VerbosePage()
            )
        )
            ->page(new FakeRequest(
                'GET',
                '/',
                'HTTP/1.1',
                [],
                ''
            ))
            ->viaOutput(
                new BaseOutput()
            )
            ->__toString();

        $expected = <<<OUTPUT
HTTP/1.1 200 OK
Content-Type: text/plain
Content-Length: 102

PhpPages-Method: GET
PhpPages-Path: /
PhpPages-Query: 
PhpPages-Protocol: HTTP/1.1
PhpPages-Body: 
OUTPUT;

        $this->assertEquals(
            $expected,
            $response
        );
    }
}