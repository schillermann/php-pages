<?php
namespace PhpPages;

interface SessionInterface
{
    function add(string $name, string $value): void;

    function array(): array;

    function clear(): void;

    function empty(): bool;

    function param(string $name): string;

    function remove(string $name): void;

    function start(): void;
}