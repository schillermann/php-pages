# Pages Framework Object Oriented With PHP

PhpPages is an experimental prototype of a web framework, inspired by [Yegor Bugayenko](https://www.yegor256.com/) with the project [jpages](https://github.com/yegor256/jpages).

## Contents
- [Quick Start](#quick-start)
- [Templates](#templates)

## Quick Start
This is how you start a web app.
```php
<?php
require __DIR__ . '/vendor/autoload.php';

use PhpPages\App;
use PhpPages\PageWithRoutes;
use PhpPages\Request;
use PhpPages\Response;
use PhpPages\TextPage;

(new App(
    new PageWithRoutes(
        '/profile',
        new TextPage('Hello World!'),
        new TextPage('Page not found')
    )
))
    ->process(
        new Request(),
        new Response()
    );
```

## Templates
Create a layout page file `layout.php`.
```php
<!DOCTYPE html>
<html>
  <head>
    <title><?= $params['title']?></title>
  </head>
  <body>
    <header>
      ss
    </header>
    <main>
      {TEMPLATE}
    </main>
  </body>
</html>
```

Create the file `page.php` to be used in the layout.
```php
<h1>Main</h1>
```

This is how you start a web app with templates.
```php
<?php
require __DIR__ . '/vendor/autoload.php';

use PhpPages\App;
use PhpPages\Output\LayoutOutput;
use PhpPages\Output\SimpleOutput;
use PhpPages\OutputInterface;
use PhpPages\PageInterface;
use PhpPages\Request\SimpleRequest;
use PhpPages\Response\SimpleResponse;
use PhpPages\Template\LayoutTemplate;
use PhpPages\Template\PageTemplate;
use PhpPages\TemplateInterface;

class Page implements PageInterface
{
    function __construct(TemplateInterface $template)
    {
        $this->template = $template;
    }

    public function page(string $name, string $value): PageInterface
    {
        return $this;
    }

    public function output(OutputInterface $output): OutputInterface
    {
        $body = $this->template->content(
            ['title' => 'Template Example']
        );
        return $output
            ->output('Content-Type', 'text/html')
            ->output('Content-Length', strlen($body))
            ->output('PhpPages-Body', $body);
    }
}

(new App(
    new Page(
        new PageTemplate(
            new LayoutTemplate(
                'layout.php'
            ),
            'page.php',
            '{TEMPLATE}'
        )
    ),
    new LayoutOutput(
        new SimpleOutput()
    )
))
    ->process(
        new SimpleRequest(),
        new SimpleResponse()
    );
```