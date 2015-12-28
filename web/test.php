<?php
/**
 * Created by PhpStorm.
 * User: victor
 * Date: 23/12/15
 * Time: 04:52 PM
 */

require __DIR__.'/../vendor/autoload.php';

use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;
use Symfony\Component\HttpFoundation\Request;

$collection = new RouteCollection();
$request = Request::createFromGlobals();

$collection->add('help', new Route('/help', array(
    'controller' => 'HelpController',
    'action' => 'indexAction'
)));
$collection->add('about', new Route('/about', array(
    'controller' => 'AboutController',
    'action' => 'indexAction'
)));

$context = new RequestContext();
$context->fromRequest(Request::createFromGlobals());
$matcher = new UrlMatcher($collection, $context);

$request->getPathInfo();

$attributes = $matcher->match($request->getPathInfo());

print_r($attributes);