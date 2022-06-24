<?php
namespace PhpPages\Request;

use PhpPages\RequestInterface;

class BaseRequest implements RequestInterface
{
    function body(): string
    {
        $body = file_get_contents('php://input');
        return ($body === false)? '' : $body;
    }

    function head(): array
    {
        return getallheaders();
    }

    function method(): string
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    function protocol(): string
    {
        return $_SERVER['SERVER_PROTOCOL'];
    }

    function uri(): string
    {
        return $_SERVER["REQUEST_URI"];
    }
}