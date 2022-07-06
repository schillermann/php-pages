<?php
namespace PhpPages\Page;

use PhpPages\OutputInterface;
use PhpPages\Page\RedirectPage;
use PhpPages\PageInterface;
use PhpPages\SessionInterface;

class SessionPage implements PageInterface
{
    private PageInterface $origin;
    private SessionInterface $session;
    private string $loginRoute;

    function __construct(PageInterface $origin, SessionInterface $session, string $loginRoute)
    {
        $this->origin = $origin;
        $this->session = $session;
        $this->loginRoute = $loginRoute;
    }
    
    function viaOutput(OutputInterface $output): OutputInterface
    {
        return $output;
    }

    function withMetadata(string $name, string $value): PageInterface
    {
        if ('PhpPages-Path' === $name) {

            if ($this->loginRoute !== $value && $this->session->empty()) {
                return new RedirectPage($this->loginRoute);
            }

            return $this->origin->withMetadata($name, $value);
        }
        
        return $this;
    }
}