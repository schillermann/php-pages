<?php
namespace PhpPages;

class SimpleOutput implements OutputInterface
{
    private array $responseList;

    public function __construct(array $responseList = [])
    {
        $this->responseList = $responseList;   
    }

    function __toString(): string {
        return implode(PHP_EOL, $this->responseList);
    }

    public function output(string $name, string $value): Outputinterface
    {
        if(!$this->responseList) {
            $this->responseList[] = 'HTTP/1.1 200 OK';
        }

        if ("PhpPages-Body" === $name) {
            $this->responseList[] = '';
            $this->responseList[] = $value;
        } else {
            $this->responseList[] = $name . ': ' . $value;
        }
        return new SimpleOutput($this->responseList);
    }

    public function write(ResponseInterface $output): void
    {
        for ($i = 0; $i < count($this->responseList); $i++) {
            if (empty($this->responseList[$i])) {
                $output->body($this->responseList[++$i]);
                continue;
            }
            $output->head($this->responseList[$i]);
        }
    }
}