# Pages Framework Object Oriented With PHP

PhpPages is an experimental prototype of a web framework, inspired by [Yegor Bugayenko](https://www.yegor256.com/) with the project [jpages](https://github.com/yegor256/jpages).

## Contents
- [Quick Start](#quick-start)
- [Templates](#templates)
- [REST-API](#rest-api)
- [Development Principles](#development-principles)
- [Measuring Complexity](#measuring-complexity)

## Quick Start
This is how you start a web app.
```php
<?php
require __DIR__ . '/vendor/autoload.php';

use PhpPages\App;
use PhpPages\OutputInterface;
use PhpPages\Page\TextPage;
use PhpPages\PageInterface;
use PhpPages\Request\NativeRequest;
use PhpPages\Response\NativeResponse;

(new App(
    new class implements PageInterface {
        public function viaOutput(OutputInterface $output): OutputInterface
        {
            return $output->withMetadata(
                PageInterface::STATUS,
                'HTTP/1.1 404 Not Found'
            );
        }

        public function withMetadata(string $name, string $value): PageInterface
        {
            if ($name !== PageInterface::PATH) {
                return $this;
            }

            if ($value === '/profile') {
                return new TextPage("It's me. It's Mario.");
            }
            
            return new TextPage('Page not found');
        }
    }
))
    ->start(
        new NativeRequest(),
        new NativeResponse()
    );
```
## Templates

Now let's see how we can reder some pages with templates.
We use PHP as template type.

First we create the `layout.php` template file.
```php
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?= $title ?></title>
</head>
<body>
    <header>
        <?= $header ?>
    </header>
    <main>
        <?= $main ?>
    </main>
</body>
</html>
```

For our page head we need the `header.php` template file.
```php
<h1><?= $headline ?></h1>
```

The application then looks like this, with our nice look and feel layout.
```php
<?php
require __DIR__ . '/vendor/autoload.php';

use PhpPages\App;
use PhpPages\OutputInterface;
use PhpPages\Page\TextPage;
use PhpPages\PageInterface;
use PhpPages\Request\NativeRequest;
use PhpPages\Response\NativeResponse;
use PhpPages\Template\PhpTemplate;
use PhpPages\TemplateInterface;

class ProfilePage implements PageInterface
{
    private TemplateInterface $layout;

    public function __construct(TemplateInterface $layout)
    {
        $this->layout = $layout;
    }

    public function viaOutput(OutputInterface $output): OutputInterface
    {
        return $output
            ->withMetadata(
                'Content-Type',
                'text/html'
            )
            ->withMetadata(
                PageInterface::BODY,
                $this->layout
                    ->withParameter(
                        'title',
                        'My Profile'
                    )
                    ->withParameter(
                        'main',
                        "<p>It's me. It's Mario.</p>"
                    )
            );
    }

    public function withMetadata(string $name, string $value): PageInterface
    {
        return $this;
    }
    
}

(new App(
    new class implements PageInterface {
        private TemplateInterface $layout;

        public function __construct()
        {
            $this->layout = (new PhpTemplate('layout.php'))
                ->withParameter(
                    'title',
                    'My Layout'
                )
                ->withParameter(
                    'header',
                    (new PhpTemplate('header.php'))
                        ->withParameter('headline', 'My Header')
                );
        }

        public function viaOutput(OutputInterface $output): OutputInterface
        {
            return $output->withMetadata(
                PageInterface::STATUS,
                'HTTP/1.1 404 Not Found'
            );
        }

        public function withMetadata(string $name, string $value): PageInterface
        {
            if ($name !== PageInterface::PATH) {
                return $this;
            }

            if ($value === '/profile') {
                return new ProfilePage($this->layout);
            }
            
            return new TextPage('Page not found');
        }
    }
))
    ->start(
        new NativeRequest(),
        new NativeResponse()
    );
```

## REST-API

Simple REST-API example.

```php
<?php
require __DIR__ . '/vendor/autoload.php';

use PhpPages\App;
use PhpPages\OutputInterface;
use PhpPages\Page\TextPage;
use PhpPages\PageInterface;
use PhpPages\Request\NativeRequest;
use PhpPages\Response\NativeResponse;

class UserById implements PageInterface
{
    public function viaOutput(OutputInterface $output): OutputInterface
    {
        return $output
            ->withMetadata(
                'Content-Type',
                'application/json'
            )
            ->withMetadata(
                PageInterface::BODY,
                json_encode(['type' => 'user with id endpoint'])
            );
    }

    public function withMetadata(string $name, string $value): PageInterface
    {
        return $this;
    }
}

(new App(
    new class implements PageInterface {
        public function viaOutput(OutputInterface $output): OutputInterface
        {
            return $output->withMetadata(
                PageInterface::STATUS,
                'HTTP/1.1 404 Not Found'
            );
        }

        public function withMetadata(string $name, string $value): PageInterface
        {
            if ($name !== PageInterface::PATH) {
                return $this;
            }

            if (preg_match('/\/users\/[0-9]+/', $value)) {
                return new UserById();
            }
            
            return new TextPage('Endpoint not found');
        }
    }
))
    ->start(
        new NativeRequest(),
        new NativeResponse()
    );
```

## Development Principles

### Exception

Avoid working with exceptions.

### Constsructor

Properties set in the constructor may not be changed.

### Method

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

## Measuring Complexity

The complexity and thus the maintainability, can be measured with different metrics.  
However, some can be applied and interpreted differently.  
This makes the [metrics inaccurate](https://thevaluable.dev/complexity-metrics-software/#measuring-complexity-is-only-the-beginning).

If you want to find hidden complexity, you could start with the simplest mertrics.
1. [LOC](https://thevaluable.dev/complexity-metrics-software/#counting-lines-of-code)
2. [Code shape](https://thevaluable.dev/complexity-metrics-software/#code-shape)
3. [Structural coupling](https://thevaluable.dev/complexity-metrics-software/#structural-coupling-static-analysis-of-the-codebase)
4. [Logical coupling](https://thevaluable.dev/complexity-metrics-software/#logical-coupling)