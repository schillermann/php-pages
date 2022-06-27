<?php
require __DIR__ . '/../../vendor/autoload.php';

use PhpPages\App;
use PhpPages\Page\PageWithRoutes;
use PhpPages\Page\TextPage;

(new App(
    new PageWithRoutes(
        '/profile',
        new TextPage("It's me. It's Mario."),
        new TextPage('Page not found')
)))
    ->start();