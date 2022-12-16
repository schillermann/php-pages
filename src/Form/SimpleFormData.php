<?php
namespace PhpPages\Form;

use PhpPages\FormDataInterface;

class SimpleFormData implements FormDataInterface
{
    private string $params; 
    private array $paramMap;

    function __construct(string $params)
    {
        $this->params = $params;
        $this->paramMap = [];
    }

    function exists(string $name): bool
    {
        if (empty($this->paramMap)) {
            $paramSplit = explode('&', $this->params);

            if (!empty($paramSplit[0])) {
                foreach ($paramSplit as $param) {
                    $paramKeyValue = explode('=', $param);
                    $this->paramMap[$paramKeyValue[0]] = urldecode($paramKeyValue[1]);
                }
            }            
        }

        return array_key_exists($name, $this->paramMap);
    }

    function param(string $name): string
    {
        if ($this->exists($name)) {
            return $this->paramMap[$name];
        }

        return '';
    }

    function paramWithDefault(string $name, string $defaultValue): string
    {
        $value = $this->param($name);
        if ($value) {
            return $value;
        }
        return $defaultValue;
    }
}