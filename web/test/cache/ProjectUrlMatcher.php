<?php

use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\RequestContext;

/**
 * ProjectUrlMatcher.
 *
 * This class has been auto-generated
 * by the Symfony Routing Component.
 */
class ProjectUrlMatcher extends Symfony\Component\Routing\Matcher\UrlMatcher
{
    /**
     * Constructor.
     */
    public function __construct(RequestContext $context)
    {
        $this->context = $context;
    }

    public function match($pathinfo)
    {
        $allow = array();
        $pathinfo = rawurldecode($pathinfo);
        $context = $this->context;
        $request = $this->request;

        if (0 === strpos($pathinfo, '/foo')) {
            // route1
            if ($pathinfo === '/foo') {
                return array (  '_controller' => 'MyController::fooAction',  '_route' => 'route1',);
            }

            // route2
            if ($pathinfo === '/foo/bar') {
                return array (  '_controller' => 'MyController::foobarAction',  '_route' => 'route2',);
            }

        }

        // route3
        if ($pathinfo === '/help') {
            return array (  '_controller' => 'MyController::foobarAction',  '_route' => 'route3',);
        }

        throw 0 < count($allow) ? new MethodNotAllowedException(array_unique($allow)) : new ResourceNotFoundException();
    }
}
