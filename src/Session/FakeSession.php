<?php
namespace PhpPages\Session;

use PhpPages\SessionInterface;

class FakeSession implements SessionInterface
{
    private array $session;

    function __construct(array $session = [])
    {
        $this->session = $session;
    }

    function add(string $name, string $value): void
    {
        $this->session[$name] = $value;
    }

    function array(): array
    {
        return $this->session;
    }

    public function exists(string $name): bool
    {
        return array_key_exists($name, $this->session);
    }

    function param(string $name): string
    {
        return $this->session[$name];
    }

    function remove(string $name): void {}

    function start(): void { }
}