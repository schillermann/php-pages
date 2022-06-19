<?php
require __DIR__ . '/vendor/autoload.php';

use PhpPages\App;
use PhpPages\LayoutOutput;
use PhpPages\OutputInterface;
use PhpPages\PageInterface;
use PhpPages\Request;
use PhpPages\Response;
use PhpPages\SimpleOutput;
use PhpPages\Template;
use PhpPages\TemplateInterface;

class LayoutPage implements PageInterface
{
    private PageInterface $origin;
    private TemplateInterface $template;

    function __construct(PageInterface $origin, TemplateInterface $template)
    {
        $this->origin = $origin;
        $this->template = $template;
    }
    public function page(string $name, string $value): PageInterface
    {
        return $this;
    }

    public function output(OutputInterface $output): OutputInterface
    {
        return $this->origin->output(
            $output
                ->output(
                    'PhpPages-Layout',
                     $this->template->content(
                        [ 'title' => 'Template Example' ]
                     )
                )
        );
    }
}

class MainPage implements PageInterface
{   
    private TemplateInterface $template;

    function __construct(TemplateInterface $template)
    {
        $this->template = $template;
    }

    function page(string $name, string $value): PageInterface
    {
        return $this;
    }

    function output(OutputInterface $output): OutputInterface
    {
        return $output
            ->output(
                'PhpPages-Template',
                $this->template->content(
                    [
                        'name' => 'Mario'
                    ]
                )
            );
    }
}

(new App(
    new LayoutPage(
        new MainPage(
            new Template(
                'pages/main.php',
            ),
        ),
        new Template(
            'pages/layout.php',
        )
    ),
    new LayoutOutput(
        new SimpleOutput()
    )
))
    ->process(
        new Request(),
        new Response()
    );