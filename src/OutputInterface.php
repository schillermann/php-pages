<?php
namespace PhpPages;

interface OutputInterface
{
    function __toString(): string;
    function withMetadata(string $name, string $value): Outputinterface;
    function writeTo(ResponseInterface $response): void;
}