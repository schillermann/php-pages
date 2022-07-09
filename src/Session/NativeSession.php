<?php
namespace PhpPages\Session;

use PhpPages\SessionInterface;

class NativeSession implements SessionInterface
{
    private array $session;

    function __construct()
    {
        $this->session = [];
    }

    function add(string $name, string $value): void
    {
        $this->session[$name] = $value;
        $_SESSION[$name] = $value;
    }

    function array(): array
    {
        return $this->session;
    }

    function clear(): void
    {
        $this->session = [];
        $_SESSION = [];
    }

    function empty(): bool
    {
        return empty($this->session);
    }

    function exists(string $name): bool
    {
        return array_key_exists($name, $this->session);
    }  

    function param(string $name): string
    {
        return $this->session[$name];
    }

    function remove(string $name): void
    {
        unset($this->session[$name]);
        unset($_SESSION[$name]);
    }

    function start(): void
    {
        if (\PHP_SESSION_ACTIVE === session_status()) {
            throw new \RuntimeException('Session already started');
        }

        session_start();
        $this->session = $_SESSION;
    }
}