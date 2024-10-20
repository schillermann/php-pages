<?php

namespace PhpPages;

interface RequestInterface
{
    /**
     * HTTP request methods
     * @link https://developer.mozilla.org/en-US/docs/Web/HTTP/Methods
     */
    const METHOD_CONNECT = 'CONNECT';
    const METHOD_DELETE = 'DELETE';
    const METHOD_GET = 'GET';
    const METHOD_HEAD = 'HEAD';
    const METHOD_OPTIONS = 'OPTIONS';
    const METHOD_POST = 'POST';
    const METHOD_PUT = 'PUT';
    const METHOD_PATCH = 'PATCH';
    const METHOD_TRACE = 'TRACE';

    function body(): string;

    function head(): array;

    function method(): string;

    function protocol(): string;

    function uri(): string;
}
