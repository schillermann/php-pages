<?php
namespace PhpPages;

class Veil
{
    private $origin;
    private array $methods;

    function __construct($origin, array $methods)
    {
        $this->origin = $origin;
        $this->methods = $methods;
    }
  
    function __call($method, $arguments)
    {
        if (array_key_exists($method, $this->methods)) {
            return $this->methods[$method];
        }
        $this->methods = [];
        return $this->origin->{$method}(...$arguments);
    }
}