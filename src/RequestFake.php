<?php
namespace PhpPages;

class RequestFake implements RequestInterface
{
    private string $body;
    private array $head;
    private string $method;
    private string $protocol;
    private string $uri;

    function __construct(
        string $method,
        string $uri,
        string $protocol,
        array $head = [],
        string $body = ''
    ) {
        $this->method = $method;
        $this->uri = $uri;
        $this->protocol = $protocol;
        $this->head = $head;
        $this->body = $body;
    }

    function body(): string
    {
        return $this->body;
    }

    function head(): array
    {
        return $this->head;
    }

    function method(): string
    {
        return $this->method;
    }

    function protocol(): string
    {
        return $this->protocol;
    }

    function uri(): string
    {
        return $this->uri;
    }
}