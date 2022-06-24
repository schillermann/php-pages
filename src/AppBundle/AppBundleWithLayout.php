<?php
namespace PhpPages\AppBundle;

use PhpPages\App;
use PhpPages\AppBundleInterface;
use PhpPages\Output\BaseOutput;
use PhpPages\Output\LayoutOutput;
use PhpPages\PageInterface;
use PhpPages\Process\BaseProcess;
use PhpPages\Request\BaseRequest;
use PhpPages\Response\BaseResponse;

class AppBundleWithLayout implements AppBundleInterface
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
            new LayoutOutput(
                new BaseOutput()
            )
        ))
            ->process(
                new BaseRequest(),
                new BaseResponse()
            );
    }
}