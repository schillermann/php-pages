<?php
require __DIR__ . '/../../vendor/autoload.php';

use PhpPages\App;
use PhpPages\OutputInterface;
use PhpPages\Page\LayoutPage;
use PhpPages\PageInterface;
use PhpPages\Request\NativeRequest;
use PhpPages\Response\NativeResponse;
use PhpPages\Template\SimpleTemplate;
use PhpPages\TemplateInterface;

class ContentPage implements PageInterface
{
    private TemplateInterface $template;
    private string $name;

    function __construct(TemplateInterface $template, string $name = '')
    {
        $this->template = $template;
        $this->name = $name;
    }

    function viaOutput(OutputInterface $output): OutputInterface
    {
        return $output->withMetadata(
            'PhpPages-Body',
            $this->template
                ->withParam('name', $this->name)
                ->content()
        );
    }

    function withMetadata(string $name, string $value): PageInterface
    {
        return $this;
    }
}

(new App(
    (new LayoutPage(
        new SimpleTemplate('layout.php'),
    ))
        ->withPage(
            new ContentPage(
                new SimpleTemplate('head.php'),
                'Mario'
            )
        )
        ->withPage(
            new ContentPage(
                new SimpleTemplate('main.php')
            )
        )
))
    ->start(
        new NativeRequest(),
        new NativeResponse()
    );
    