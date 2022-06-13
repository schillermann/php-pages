<?php
namespace PhpPages;

interface OutputInterface
{
    function __toString(): string;
    function metadata(string $name, string $value): Outputinterface;
    function print(OutputStreamInterface $output): void;
}