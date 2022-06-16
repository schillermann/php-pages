<?php
namespace PhpPages;

interface OutputInterface
{
    function __toString(): string;
    function output(string $name, string $value): Outputinterface;
    function write(ResponseInterface $output): void;
}