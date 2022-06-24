<?php
namespace PhpPages;

interface PageInterface
{
    function viaOutput(OutputInterface $output): OutputInterface;

    function withMetadata(string $name, string $value): PageInterface;
}