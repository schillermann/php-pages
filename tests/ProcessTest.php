<?php

namespace PhpPages\Tests;

use PhpPages\Page\VerbosePage;
use PhpPages\Process;
use PhpPages\Request\FakeRequest;
use PhpPages\SimpleOutput;
use PHPUnit\Framework\TestCase;

class ProcessTest extends TestCase
{
    function testCanGetOutput(): void
    {
        $response = (new Process(
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
                new SimpleOutput()
            )
            ->__toString();

        $expected = <<<OUTPUT
        HTTP/1.1 200 OK
        Content-Length: 98
        Content-Type: text/plain

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
