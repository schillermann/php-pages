<?php
namespace PhpPages\Output;

use PhpPages\OutputInterface;
use PhpPages\ResponseInterface;

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

        if (str_starts_with($name, 'PhpPages-Template')) {
            $placeholder = strtoupper(substr($name, 9));
            $layout = str_replace('{' . $placeholder . '}', $value, $this->layout);
            $foundPlaceHolders = preg_match('/\{TEMPLATE.*\}/i', $layout);

            if ($foundPlaceHolders) {
                return new LayoutOutput(
                    clone $this->origin,
                    $layout
                );
            }

            return new LayoutOutput(
                $this->origin->output('PhpPages-Body', $layout),
                $layout
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