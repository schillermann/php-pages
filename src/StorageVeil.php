<?php
namespace PhpPages;

class StorageVeil
{
    private $origin;
    private array $methods;
    private bool $unveil;

    function __construct($origin, array $methods, bool $unveil = true)
    {
        $this->origin = $origin;
        $this->methods = $methods;
        $this->unveil = $unveil;
    }
  
    function __call($method, $arguments)
    {
        if (array_key_exists($method, $this->methods)) {
            return $this->methods[$method];
        }

        if ($this->unveil) {
            $this->methods = [];
        }
        
        return $this->origin->{$method}(...$arguments);
    }
}