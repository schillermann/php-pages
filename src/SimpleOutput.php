<?php
namespace PhpPages;

class SimpleOutput implements OutputInterface
{
    private array $buffer;

    public function __construct(array $buffer = [])
    {
        $this->buffer = $buffer;   
    }

    function __toString(): string {
        return implode(PHP_EOL, $this->buffer);
    }

    public function metadata(string $name, string $value): Outputinterface
    {
        if(!$this->buffer) {
            $this->buffer[] = 'HTTP/1.1 200 OK';
        }

        if ("PhpPages-Body" === $name) {
            $this->buffer[] = '';
            $this->buffer[] = $value;
        } else {
            $this->buffer[] = $name . ': ' . $value;
        }
        return new SimpleOutput($this->buffer);
    }

    public function print(OutputStreamInterface $output): void
    {
        for ($i = 0; $i < count($this->buffer); $i++) {
            if (empty($this->buffer[$i])) {
                $output->write($this->buffer[++$i]);
                continue;
            }
            header($this->buffer[$i]);
            $output->close();
        }
    }
}