# Pages Framework Object Oriented With PHP

PhpPages is an experimental prototype of a web framework, inspired by [Yegor Bugayenko](https://www.yegor256.com/) with the project [jpages](https://github.com/yegor256/jpages).

This is how you start a web app:
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