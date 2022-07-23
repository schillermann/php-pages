# Pages Framework Object Oriented With PHP

PhpPages is an experimental prototype of a web framework, inspired by [Yegor Bugayenko](https://www.yegor256.com/) with the project [jpages](https://github.com/yegor256/jpages).

## Contents
- [Quick Start](#quick-start)
- [Routing](examples/routing/index.php)
- [Template](examples/template/index.php)
- [Development Principles](#development-principles)

## Quick Start
This is how you start a web app.
```php
<?php
require __DIR__ . '/vendor/autoload.php';

use PhpPages\App;
use PhpPages\Page\PageWithRoutes;
use PhpPages\Page\TextPage;
use PhpPages\Request\NativeRequest;
use PhpPages\Response\NativeResponse;

(new App(
    (new PageWithRoutes(
        new TextPage('Page not found')
        
    ))
        ->withRoute(
            '/profile',
            new TextPage("It's me. It's Mario.")
        )
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