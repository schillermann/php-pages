<?php
namespace PhpPages\Output;

use PhpPages\OutputInterface;
use PhpPages\ResponseInterface;

class SimpleOutput implements OutputInterface
{
    private array $lines;

    public function __construct(array $lines = [])
    {
        $this->lines = $lines;   
    }

    function __toString(): string {
        return implode(PHP_EOL, $this->lines);
    }

    public function output(string $name, string $value): Outputinterface
    {
        if(!$this->lines) {
            $this->lines[] = 'HTTP/1.1 200 OK';
        }

        if ("PhpPages-Body" === $name) {
            $this->lines[] = '';
            $this->lines[] = $value;
        } else {
            $this->lines[] = $name . ': ' . $value;
        }
        return new SimpleOutput($this->lines);
    }

    public function write(ResponseInterface $output): void
    {
        for ($i = 0; $i < count($this->lines); $i++) {
            if (empty($this->lines[$i])) {
                $output->body($this->lines[++$i]);
                continue;
            }
            $output->head($this->lines[$i]);
        }
    }
}