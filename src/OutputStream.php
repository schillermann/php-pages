<?php
namespace PhpPages;

class OutputStream implements OutputStreamInterface
{
    private string $streamType;
    private $stream;

    function __construct(string $streamType)
    {
        $this->streamType = $streamType;        
    }

    function write(string $data): void
    {
        if (!is_resource($this->stream)) {
            $this->stream = fopen( $this->streamType, 'a');
        }
        fwrite($this->stream, $data);
    }

    function close(): void
    {
        if (is_resource($this->stream)) {
            fclose($this->stream);
        }
    }
}