<?php
namespace PhpPages;

class App
{
    private ProcessInterface $process;
    private OutputInterface $output;

    function __construct(ProcessInterface $process, OutputInterface $output)
    {
        $this->process = $process;
        $this->output = $output;
    }

    function process(RequestInterface $request, ResponseInterface $response): void
    {
        $this->process
            ->page($request)
            ->viaOutput($this->output)
            ->writeTo($response);
    }
}