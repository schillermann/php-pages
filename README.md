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
        function viaOutput(OutputInterface $output): OutputInterface
        {
            return $output->withMetadata(
                PageInterface::STATUS,
                'HTTP/1.1 404 Not Found'
            );
        }

        function withMetadata(string $name, string $value): PageInterface
        {
            if ($name !== PageInterface::METADATA_PATH) {
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

    function __construct(TemplateInterface $layout)
    {
        $this->layout = $layout;
    }

    function viaOutput(OutputInterface $output): OutputInterface
    {
        return $output
            ->withMetadata(
                'Content-Type',
                'text/html'
            )
            ->withMetadata(
                PageInterface::METADATA_BODY,
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

    function withMetadata(string $name, string $value): PageInterface
    {
        return $this;
    }

}

(new App(
    new class implements PageInterface {
        private TemplateInterface $layout;

        function __construct()
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

        function viaOutput(OutputInterface $output): OutputInterface
        {
            return $output->withMetadata(
                PageInterface::STATUS,
                'HTTP/1.1 404 Not Found'
            );
        }

        function withMetadata(string $name, string $value): PageInterface
        {
            if ($name !== PageInterface::METADATA_PATH) {
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
use PhpPages\PageInterface;
use PhpPages\Request\NativeRequest;
use PhpPages\Response\NativeResponse;

class UserGet implements PageInterface
{
    function viaOutput(OutputInterface $output): OutputInterface
    {
        return $output
            ->withMetadata(
                'Content-Type',
                'application/json'
            )
            ->withMetadata(
                PageInterface::METADATA_BODY,
                json_encode(['type' => 'user with id endpoint'])
            );
    }

    function withMetadata(string $name, string $value): PageInterface
    {
        return $this;
    }
}

class GetPage implements PageInterface
{
    function viaOutput(OutputInterface $output): OutputInterface
    {
        return $output->withMetadata(
            PageInterface::STATUS,
            'HTTP/1.1 404 Not Found'
        );
    }

    function withMetadata(string $name, string $value): PageInterface
    {
        if ($name !== PageInterface::PATH) {
            return $this;
        }

        if (preg_match('/\/users\/[0-9]+/', $value)) {
            return new UserGet();
        }
        return $this;
    }
}

(new App(
    new class implements PageInterface {
        function __construct(private string $httpMethod = '')
        {
            $this->httpMethod = $httpMethod;
        }

        function viaOutput(OutputInterface $output): OutputInterface
        {
            return $output->withMetadata(
                PageInterface::STATUS,
                'HTTP/1.1 404 Not Found'
            );
        }

        function withMetadata(string $name, string $value): PageInterface
        {
            if ($name !== PageInterface::METADATA_METHOD) {
                return $this;
            }

            if (RequestInterface::METHOD_GET === $value) {
                return new GetPage()
            }

            return $this;
        }
    }
))
    ->start(
        new NativeRequest(),
        new NativeResponse()
    );
```

### Validate Request Body JSON

```php
<?php
require __DIR__ . '/vendor/autoload.php';

use PhpPages\App;
use PhpPages\OutputInterface;
use PhpPages\PageInterface;
use PhpPages\Page\Request\RequestConstraints;
use PhpPages\Request\NativeRequest;
use PhpPages\Response\NativeResponse;

class UserPost implements PageInterface
{
    function __construct(
        private RequestConstraints $requestConstraints,
        private array $requestBody = []
    ) {
    }

    function viaOutput(OutputInterface $output): OutputInterface
    {
        $this->requestConstraints->check($this->requestBody);
        if ($this->requestConstraints->hasErrors()) {
            return $output->withMetadata(
                PageInterface::STATUS,
                PageInterface::STATUS_400_BAD_REQUEST
            )->withMetadata(
                PageInterface::BODY,
                json_encode(['errors' => $this->requestConstraints->errors()])
            );
        }

        return $output
            ->withMetadata(
                'Content-Type',
                'application/json'
            )
            ->withMetadata(
                PageInterface::STATUS,
                PageInterface::STATUS_201_CREATED
            )
            ->withMetadata(
                PageInterface::METADATA_BODY,
                json_encode([
                    'email' => $this->requestBody['email'],
                    'username' => isset($this->requestBody['username'])? $this->requestBody['username'] : '',
                ])
            );
    }

    function withMetadata(string $name, string $value): PageInterface
    {
        if (PageInterface::BODY !== $name) {
            return $this;
        }

        return new self(
            $this->requestConstraints,
            json_decode($value, true)
        );
    }
}

class PostPage implements PageInterface
{
    function viaOutput(OutputInterface $output): OutputInterface
    {
        return $output->withMetadata(
            PageInterface::STATUS,
            'HTTP/1.1 404 Not Found'
        );
    }

    function withMetadata(string $name, string $value): PageInterface
    {
        if ($name !== PageInterface::PATH) {
            return $this;
        }

        if ('/users' === $value)) {
            return new UserPost(
                (new RequestConstraints())
                ->withProperty(
                    'email',
                    new ConstraintNotBlank(),
                    new ConstraintEmail()
                    new ConstraintType('string'),
                    new ConstraintLength(2, 50)
                )
                ->withProperty(
                    'username',
                    new ConstraintType('string'),
                    new ConstraintLength(2, 50)
                )
            );
        }
        return $this;
    }
}

(new App(
    new class implements PageInterface {
        function __construct(private string $httpMethod = '')
        {
            $this->httpMethod = $httpMethod;
        }

        function viaOutput(OutputInterface $output): OutputInterface
        {
            return $output->withMetadata(
                PageInterface::STATUS,
                'HTTP/1.1 404 Not Found'
            );
        }

        function withMetadata(string $name, string $value): PageInterface
        {
            if ($name !== PageInterface::METADATA_METHOD) {
                return $this;
            }

            if (RequestInterface::METHOD_POST === $value) {
                return new PostPage()
            }

            return $this;
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
