<?php

namespace Olla\React\Renderer;

use Symfony\Component\HttpFoundation\RequestStack;
use Olla\React\Context;


class AppContext implements Context
{
    private $requestStack;
    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }
    public function getContext()
    {
        $request = $this->requestStack->getCurrentRequest();
        return [
            'href' => $request->getSchemeAndHttpHost().$request->getRequestUri(),
            'location' => $request->getRequestUri(),
            'scheme' => $request->getScheme(),
            'host' => $request->getHost(),
            'port' => $request->getPort(),
            'base' => $request->getBaseUrl(),
            'pathname' => $request->getPathInfo(),
            'search' => $request->getQueryString(),
        ];
    }
}
