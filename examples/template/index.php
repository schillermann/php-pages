<?php
require __DIR__ . '/../../vendor/autoload.php';

use PhpPages\App;
use PhpPages\OutputInterface;
use PhpPages\PageInterface;
use PhpPages\Template\SimpleTemplate;
use PhpPages\TemplateInterface;

class ContentPage implements PageInterface
{
    private TemplateInterface $template;
    private array $params;

    function __construct(TemplateInterface $template, array $params = [])
    {
        $this->template = $template;
        $this->params = $params;
    }

    function viaOutput(OutputInterface $output): OutputInterface
    {
        return $output->withMetadata(
            'PhpPages-Body',
            $this->template->content($this->params)
        );
    }

    function withMetadata(string $name, string $value): PageInterface
    {
        return $this;
    }
}

class LayoutPage implements PageInterface
{
    private TemplateInterface $layout;
    private PageInterface $head;
    private PageInterface $main;
    private PageInterface $foot;

    function __construct(TemplateInterface $layout, PageInterface $head, PageInterface $main, PageInterface $foot)
    {
        $this->layout = $layout;
        $this->head = $head;
        $this->main = $main;
        $this->foot = $foot;
    }
    function viaOutput(OutputInterface $output): OutputInterface
    {
        $layoutSplit = preg_split(
            '({HEAD}|{MAIN}|{FOOT})',
            $this->layout->content(
                ['title' => 'Hello World!']
            )
        );

        $outputWithStart = $output->withMetadata('PhpPages-Body', $layoutSplit[0]);

        $outputWithHead = $this->head->viaOutput($outputWithStart)
            ->withMetadata('PhpPages-Body', $layoutSplit[1]);
        
        $outputWithMain = $this->main->viaOutput($outputWithHead)
            ->withMetadata('PhpPages-Body', $layoutSplit[2]);

        $footOutput = $this->foot->viaOutput($outputWithMain)
            ->withMetadata('PhpPages-Body',$layoutSplit[3]);
        
        return $footOutput;
    }

    function withMetadata(string $name, string $value): PageInterface
    {
        return $this;   
    }
}

(new App(
    new LayoutPage(
        new SimpleTemplate('layout.php'),
        new ContentPage(
            new SimpleTemplate('head.php'),
            [ 'name' => 'Mario' ]
        ),
        new ContentPage(
            new SimpleTemplate('main.php')
        ),
        new ContentPage(
            new SimpleTemplate('foot.php')
        )
    )
))
    ->start();