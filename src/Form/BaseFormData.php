<?php
namespace PhpPages\Form;

use PhpPages\FormDataInterface;

class BaseFormData implements FormDataInterface
{
    private string $params; 
    private array $paramMap;

    function __construct(string $params)
    {
        $this->params = $params;
        $this->paramMap = [];
    }

    function param(string $name): string
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
        if (array_key_exists($name, $this->paramMap)) {
            return $this->paramMap[$name];
        }

        throw new \OutOfRangeException('Param "' . $name . '" is not a part of form data');
    }
}