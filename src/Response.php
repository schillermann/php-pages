<?php
namespace PhpPages;

class Response implements ResponseInterface
{
    public function head(string $head): void
    {
        header($head);
    }

    public function body(string $body): void
    {
        echo $body;
    }
}