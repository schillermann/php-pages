<?php
namespace PhpPages\Response;

use PhpPages\ResponseInterface;

class SimpleResponse implements ResponseInterface
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