<?php
require __DIR__ . '/../../vendor/autoload.php';

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