<?php
/**
 * Created by PhpStorm.
 * User: victor
 * Date: 23/12/15
 * Time: 04:52 PM
 */

require __DIR__.'/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Config\FileLocator;

use Symfony\Component\Routing;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\Router;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\Loader\YamlFileLoader;


$locator = new FileLocator(array(__DIR__.'/test/'));
$loader = new YamlFileLoader($locator);
$collection = $loader->load('route.yml');
$request = Request::createFromGlobals();

$context = new RequestContext();
$context->fromRequest(Request::createFromGlobals());
$matcher = new UrlMatcher($collection, $context);

try {
    $attributes = $matcher->match($request->getPathInfo());
    print_r($attributes);
} catch (Routing\Exception\ResourceNotFoundException $e) {
    $response = new Response('Not Found', 404);
    $response->send();
} catch (Exception $e) {
    $response = new Response('An error occurred', 500);
    $response->send();
}

