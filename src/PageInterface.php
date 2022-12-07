<?php
namespace PhpPages;

interface PageInterface
{
    const STATUS = 'PhpPages-Status';
    const PROTOCOL = 'PhpPages-Protocol';
    const METHOD = 'PhpPages-Method';
    const PATH = 'PhpPages-Path';
    const QUERY = 'PhpPages-Query';
    const BODY = 'PhpPages-Body';

    function viaOutput(OutputInterface $output): OutputInterface;

    function withMetadata(string $name, string $value): PageInterface;
}