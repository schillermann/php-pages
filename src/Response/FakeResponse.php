<?php
namespace PhpPages\Response;

use PhpPages\ResponseInterface;

class FakeResponse implements ResponseInterface
{
    private array $headList = [];
    private array $bodyList = [];

    function __toString(): string
    {
        return
            implode(PHP_EOL, $this->headList) .
            PHP_EOL .
            PHP_EOL .
            implode(PHP_EOL, $this->bodyList);
    }

    function head(string $head): void
    {
        $this->headList[] = $head;    
    }

    function body(string $body): void
    {
        $this->bodyList[] = $body;   
    }
}