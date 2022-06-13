<?php
namespace PhpPages;

interface OutputStreamInterface
{
    function close(): void;

    function write(string $input): void;
}