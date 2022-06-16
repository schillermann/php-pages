<?php
namespace PhpPages;

interface PageInterface
{
    function page(string $name, string $value): PageInterface;
    function output(OutputInterface $output): OutputInterface;
}