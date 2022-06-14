<?php
namespace PhpPages;

interface PageInterface
{
    function metadata(string $name, string $value): PageInterface;
    function via(OutputInterface $output): OutputInterface;
}