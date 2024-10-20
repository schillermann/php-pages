<?php

namespace PhpPages\Tests;

use PhpPages\App;
use PhpPages\OutputInterface;
use PhpPages\Page\TextPage;
use PhpPages\PageInterface;
use PhpPages\Request\FakeRequest;
use PhpPages\Response\FakeResponse;
use PHPUnit\Framework\TestCase;

class AppTest extends TestCase
{
    function testCanGetResponse(): void
    {
        $request = new FakeRequest(
            'GET',
            '/profile',
            'HTTP/1.1'
        );
        $response = new FakeResponse();

        (new App(
            new class () implements PageInterface {
                public function viaOutput(OutputInterface $output): OutputInterface
                {
                    return $output->withMetadata(
                        PageInterface::STATUS,
                        'HTTP/1.1 404 Not Found'
                    );
                }

                public function withMetadata(string $name, string $value): PageInterface
                {
                    if ($name !== PageInterface::METADATA_PATH) {
                        return $this;
                    }

                    if ($value === '/profile') {
                        return new TextPage('My Profile');
                    }

                    return new TextPage('Page not Found');
                }
            }
        ))
            ->start($request, $response);

        $expected = <<<OUTPUT
        HTTP/1.1 200 OK
        Content-Length: 10
        Content-Type: text/plain

        My Profile
        OUTPUT;

        $this->assertEquals(
            $expected,
            $response->__toString()
        );
    }
}
