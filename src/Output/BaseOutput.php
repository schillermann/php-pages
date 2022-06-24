<?php
namespace PhpPages\Output;

use PhpPages\OutputInterface;
use PhpPages\ResponseInterface;

class BaseOutput implements OutputInterface
{
    private array $head;
    private array $body;

    public function __construct(array $head = [], array $body = [])
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
            implode(PHP_EOL, $this->body);
    }

    public function withMetadata(string $name, string $value): Outputinterface
    {
        if(!$this->head) {
            $this->head[] = 'HTTP/1.1 200 OK';
        }

        if ("PhpPages-Body" === $name) {
            $this->body[] = $value;
        } else {
            $this->head[] = $name . ': ' . $value;
        }
        return new BaseOutput($this->head, $this->body);
    }

    public function writeTo(ResponseInterface $response): void
    {
        for ($i = 0; $i < count($this->head); $i++) {
            $response->head($this->head[$i]);
        }

        $response->body(
            implode(PHP_EOL, $this->body)
        );
    }
}