<?php
/**
 * Index File.
 *
 * @author  Björn Pfoster
 */
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

require_once __DIR__ . "/../config/bootstrap.php";
try {
    // Request and response
    $request = request();
    $response = response();

    $routes = config()->get("routes");
    dispatch($request, $response, $routes);
} catch (ResourceNotFoundException $exception) {
    $errorUrl = baseurl("/error-404");
    header("Location: $errorUrl");
}