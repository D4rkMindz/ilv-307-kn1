<?php

use Symfony\Component\Routing\RouteCollection;

$routes = new RouteCollection();

/**
 * Index
 */
$routes->add('/index_get', route('GET', '/', ['App\Controller\IndexController', 'index']));
$routes->get('/index_get')->addDefaults(['_auth' => false]);

$routes->add('/produkte_get', route('GET', '/produkte', ['App\Controller\ProductController', 'index']));
$routes->get('/produkte_get')->addDefaults(['_auth' => false]);

$routes->add('/fleisch_get', route('GET', '/produkte/fleisch', ['App\Controller\ProductController', 'meat']));
$routes->get('/fleisch_get')->addDefaults(['_auth' => false]);

$routes->add('/rind_get', route('GET', '/produkte/fleisch/rind', ['App\Controller\ProductController', 'beef']));
$routes->get('/rind_get')->addDefaults(['_auth' => false]);

$routes->add('/kaninchen_get', route('GET', '/produkte/fleisch/kaninchen', ['App\Controller\ProductController', 'rabbit']));
$routes->get('/kaninchen_get')->addDefaults(['_auth' => false]);

$routes->add('/pflanzlich_get', route('GET', '/produkte/pflanzlich', ['App\Controller\ProductController', 'vegetables']));
$routes->get('/pflanzlich_get')->addDefaults(['_auth' => false]);

$routes->add('/oeffnungszeiten_get', route('GET', '/öffnungszeiten', ['App\Controller\IndexController', 'openingHours']));
$routes->get('/oeffnungszeiten_get')->addDefaults(['_auth' => false]);

$routes->add('/kontakt_get', route('GET', '/kontakt', ['App\Controller\IndexController', 'contact']));
$routes->get('/kontakt_get')->addDefaults(['_auth' => false]);

$routes->add('/shopping_cart_get', route('GET', '/warenkorb', ['App\Controller\ShoppingCartController','index']));
$routes->get('/shopping_cart_get')->addDefaults(['_auth'=> false]);

$routes->add('/weather_get', route('GET', '/wetter', ['App\Controller\WeatherController','index']));
$routes->get('/weather_get')->addDefaults(['_auth'=> false]);

$routes->add('/shopping_cart_post', route('POST', '/warenkorb', ['App\Controller\ShoppingCartController','placeItem']));
$routes->get('/shopping_cart_post')->addDefaults(['_auth'=> false]);

$routes->add('/shopping_cart_put', route('PUT', '/warenkorb', ['App\Controller\ShoppingCartController','updateItem']));
$routes->get('/shopping_cart_put')->addDefaults(['_auth'=> false]);

$routes->add('/shopping_cart_delete', route('DELETE', '/warenkorb', ['App\Controller\ShoppingCartController','deleteItem']));
$routes->get('/shopping_cart_delete')->addDefaults(['_auth'=> false]);

$routes->add('/shopping_cart_order_post', route('POST', '/bestellen', ['App\Controller\ShoppingCartController','order']));
$routes->get('/shopping_cart_order_post')->addDefaults(['_auth'=> false]);

return $routes;
