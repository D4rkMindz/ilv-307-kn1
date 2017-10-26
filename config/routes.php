<?php

use Symfony\Component\Routing\RouteCollection;

$routes = new RouteCollection();

/**
 * Index
 */
$routes->add('/index_get', route('GET', '/', ['App\Controller\IndexController', 'index']));
$routes->get('/index_get')->addDefaults(['_auth' => false]);

/**
 * Error
 */
$routes->add('/error_get', route('GET', '/error/{errorcode}', ['App\Controller\ErrorController', 'index']));
$routes->get('/error_get')->setRequirements(['errorcode' => '\d+']);
$routes->get('/error_get')->addDefaults(['_auth' => false]);

/**
 * Language
 */
$routes->add('/language', route('GET', '/language', ['App\Controller\LanguageController', 'language']));
$routes->get('/language')->addDefaults(['_auth' => false]);

/**
 * Authorization
 */
$routes->add('/authorize_add',
    route(['POST', 'OPTIONS'], '/authorize', ['App\Controller\Api\AuthorizationController', 'getAuth']));
$routes->get('/authorize_add')->addDefaults(['_auth' => false]);

return $routes;
