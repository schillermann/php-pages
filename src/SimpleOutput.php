<?php

namespace PhpPages;

use PhpPages\OutputInterface;
use PhpPages\ResponseInterface;

class SimpleOutput implements OutputInterface
{
    private array $head;
    private string $body;

    public function __construct(array $head = [], string $body = '')
    {
        $this->head = $head;
        $this->body = $body;
    }

    function __toString(): string
    {
        return
            implode(PHP_EOL, $this->head) .
            PHP_EOL .
            PHP_EOL .
            $this->body;
    }

    function withMetadata(string $name, string $value): Outputinterface
    {
        if (!$this->head) {
            $this->head[] = 'HTTP/1.1 200 OK';
            $this->head[] = 'Content-Length: 0';
        }

        if (PageInterface::STATUS === $name) {
            $this->head[0] = $value;
        } elseif (PageInterface::METADATA_BODY === $name) {
            $this->body .= ($this->body) ? PHP_EOL . $value : $value;
            $this->head[1] = 'Content-Length: ' . strlen($this->body);
        } else {
            $this->head[] = $name . ': ' . $value;
        }
        return new self($this->head, $this->body);
    }

    function writeTo(ResponseInterface $response): void
    {
        foreach ($this->head as $headRow) {
            $response->head($headRow);
        }

        $response->body($this->body);
    }
}
