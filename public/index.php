<?php
/**
 * Index File.
 *
 * @author  Björn Pfoster
 */

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access-control-allow-origin,content-type,authorization");

use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\HttpFoundation\JsonResponse;

require_once __DIR__ . "/../config/bootstrap.php";
try {
    // Request and response
    $request = request();
    $response = response();/*
    if ($request->getMethod() == 'OPTIONS'){
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set('Access-Control-Allow-Headers', 'access-control-allow-origin,content-type,authorization');
        return $response->send();
    }*/

    $routes = config()->get("routes");
    dispatch($request, $response, $routes);
} catch (ResourceNotFoundException $exception) {
    logger('errors-at')->error($exception->getMessage());
    return new JsonResponse(['status' => 'error', 'message' => 'PAGE_NOT_FOUND'], 404);
}
