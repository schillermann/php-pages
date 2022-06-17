<?php
namespace PhpPages;

class LayoutOutput implements OutputInterface
{
    private OutputInterface $origin;
    private string $layout;

    public function __construct(OutputInterface $origin, string $layout = '')
    {
        $this->origin = $origin;
        $this->layout = $layout;
    }

    function __toString(): string {
        return $this->origin->__toString();
    }

    public function output(string $name, string $value): Outputinterface
    {
        if ('PhpPages-Layout' === $name) {
            return new LayoutOutput(
                clone $this->origin,
                $value
            );
        }

        if ('PhpPages-Template' === $name) {
            return new LayoutOutput(
                $this->origin->output(
                    'PhpPages-Body',
                    str_replace('{TEMPLATE}', $value, $this->layout)
                ),
                $this->layout
            );
        }

        return new LayoutOutput(
            $this->origin->output($name, $value),
            $this->layout
        );
    }

    public function write(ResponseInterface $output): void
    {
        $this->origin->write($output);
    }
}