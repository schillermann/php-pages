<?php
namespace PhpPages\Page;

use PhpPages\OutputInterface;
use PhpPages\PageInterface;
use PhpPages\PageLayoutInterface;
use PhpPages\TemplateInterface;

class LayoutPage implements PageLayoutInterface
{
    private TemplateInterface $layout;
    private array $params;
    private array $pages;

    function __construct(TemplateInterface $layout, array $params = [], array $pages = [])
    {
        $this->layout = $layout;
        $this->params = $params;
        $this->pages = $pages;
    }

    function viaOutput(OutputInterface $output): OutputInterface
    {

        $layoutSplit = explode(
            '{TEMPLATE}',
            $this->layout->content(
                $this->params
            )
        );

        $pageIndex = 0;
        $numberOfPages = count($this->pages);
        foreach ($layoutSplit as $layoutPart) {

            $output = $output->withMetadata('PhpPages-Body', $layoutPart);

            if ($numberOfPages === $pageIndex) {
                break;
            }
            $output = $this->pages[$pageIndex++]->viaOutput($output);
        }
        
        return $output;
    }

    function withMetadata(string $name, string $value): PageInterface
    {
        return $this;   
    }

    function withPage(PageInterface $page): PageLayoutInterface
    {
        $this->pages[] = $page;
        return new LayoutPage($this->layout, $this->params, $this->pages);
    }
}