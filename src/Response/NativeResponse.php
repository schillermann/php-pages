<?php
namespace PhpPages\Response;

use PhpPages\ResponseInterface;

class NativeResponse implements ResponseInterface
{
    public function head(string $head): void
    {
        header($head, false);
    }

    public function body(string $body): void
    {
        echo $body;
    }
}