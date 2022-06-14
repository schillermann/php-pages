<?php
namespace PhpPages;

interface OutputInterface
{
    function __toString(): string;
    function metadata(string $name, string $value): Outputinterface;
    function print(ResponseInterface $output): void;
}