<?php
namespace PhpPages\AppBundle;

use PhpPages\App;
use PhpPages\AppBundleInterface;
use PhpPages\Output\BaseOutput;
use PhpPages\PageInterface;
use PhpPages\Process\BaseProcess;
use PhpPages\Request\BaseRequest;
use PhpPages\Response\BaseResponse;

class AppBundleBasic implements AppBundleInterface
{
    private PageInterface $page;

    function __construct(PageInterface $page)
    {
        $this->page = $page;
    }

    function start(): void
    {
        (new App(
            new BaseProcess(
                $this->page
            ),
            new BaseOutput()
        ))
            ->process(
                new BaseRequest(),
                new BaseResponse()
            );
    }
}