# Pages Framework Object Oriented With PHP

PhpPages is an experimental prototype of a web framework, inspired by [Yegor Bugayenko](https://www.yegor256.com/) with the project [jpages](https://github.com/yegor256/jpages).

## Contents
- [Quick Start](#quick-start)
- [Templates](#templates)
- [Development Principles](#development-principles)

## Quick Start
This is how you start a web app.
```php
<?php
require __DIR__ . '/vendor/autoload.php';

use PhpPages\AppBundle\AppBundleBasic;
use PhpPages\Page\PageWithRoutes;
use PhpPages\Page\TextPage;

require __DIR__ . '/vendor/autoload.php';

(new AppBundleBasic(
    new PageWithRoutes(
        '/profile',
        new TextPage("It's me. It's Mario."),
        new TextPage('Page not found')
)))
    ->start();
```

## Templates
Create a layout page file `layout.php`.
```php
<!DOCTYPE html>
<html>
  <head>
    <title><?= $this->params['title']?></title>
  </head>
  <body>
    <main>
      {TEMPLATE}
    </main>
  </body>
</html>
```

Create the file `page.php` to be used in the layout.
```php
<h1>Hello <?= $this->params['name']; ?>!</h1>
```

This is how you start a web app with templates.
```php
<?php
require __DIR__ . '/vendor/autoload.php';

use PhpPages\AppBundle\AppBundleWithLayout;
use PhpPages\OutputInterface;
use PhpPages\PageInterface;
use PhpPages\Template\SimpleTemplate;
use PhpPages\TemplateInterface;

class Page implements PageInterface
{
    function __construct(TemplateInterface $layout)
    {
        $this->layout = $layout;
    }

    public function viaOutput(OutputInterface $output): OutputInterface
    {
        $body = (new SimpleTemplate(
            'page.php',
            ['name' => 'Mario']
        ))
            ->withLayout($this->layout, '{TEMPLATE}')
            ->content();

        return $output
            ->withMetadata('Content-Type', 'text/html')
            ->withMetadata('Content-Length', strlen($body))
            ->withMetadata('PhpPages-Body', $body);
    }

    public function withMetadata(string $name, string $value): PageInterface
    {
        return $this;
    }
}

(new AppBundleWithLayout(
    new Page(
        new SimpleTemplate(
            'layout.php',
            [ 'title' => 'Template Example' ]
        )
)))
    ->start();
```

## Development Principles
### Class Structure
Methods of a class are builders or manipulators.

Builder is ...
1. noun
2. no modifications to the encapsulated data ([Pure function](https://en.wikipedia.org/wiki/Pure_function) without side-effects)
3. returns object

Manipulator is ...
1. verb
2. modifying encapsulated data
3. returns void

Source: [Builders and Manipulators](https://www.yegor256.com/2018/08/22/builders-and-manipulators.html)