<?php

use MatthiasMullie\Minify;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;

/**
 * Check if blank
 * check if $value is empty and not numeric.
 *
 * @param string $value
 *
 * @return bool true if $value is blank
 */
function blank($value)
{
    if (empty($value) && !is_numeric($value)) {
        $result = true;
    } else {
        $result = false;
    }

    return $result;
}

/**
 * Handling email
 *
 * This function is shortening for filter_var.
 *
 * @see filter_var()
 *
 * @param string $email to check
 *
 * @return mixed
 */
function is_email($email)
{
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

/**
 * Read Assets function.
 *
 * @param mixed $file
 *
 * @return string
 */
function asset($file)
{
    $view = view();
    $config = config();
    $cache = new FilesystemAdapter('', 0, $config->get('assets')['cachePath']);
    $assets = [];
    $minify = $config->get('assets')['minimize'];
    foreach ((array)$file as $fileNew) {
        $fileName = $fileNew;
        if (!file_exists($fileNew)) {
            $fileName = $view->make($fileNew)->path();
        }
        $fileType = pathinfo($fileName, PATHINFO_EXTENSION);
        $cacheKey = sha1($fileNew . $minify . filemtime($fileName));
        $cacheItem = $cache->getItem($cacheKey);
        if (!$cacheItem->isHit()) {
            $content = '';
            if ($fileType == "js") {
                $content = asset_js($fileName, $minify);
            }
            if ($fileType == "css") {
                $content = asset_css($fileName, $minify);
            }
            $cacheItem->set($content);
            $cache->save($cacheItem);
        }
        $assets[] = $cacheItem->get();
    }
    $result = implode("\n", $assets);

    return $result;
}

/**
 * Minimise JS.
 * Minimise default JavaScript file.
 *
 * @param string $fileName Name of default JS file
 * @param bool $minify Minify js if true
 *
 * @return string JavaScript code
 */
function asset_js($fileName, $minify)
{
    if ($minify) {
        $minifier = new Minify\JS($fileName);
        $content = $minifier->minify();
    } else {
        $content = file_get_contents($fileName);
    }
    $asset = sprintf("<script type='text/javascript'>%s</script>", $content);

    return $asset;
}

/**
 * Minimise CSS.
 * Minimise default CSS file.
 *
 * @param string $fileName Name of default CSS file
 * @param bool $minify Minify css if true
 *
 * @return string CSS code
 */
function asset_css($fileName, $minify)
{
    if ($minify) {
        $minifier = new Minify\CSS($fileName);
        $content = $minifier->minify();
    } else {
        $content = file_get_contents($fileName);
    }
    $asset = sprintf("<style>%s</style>", $content);

    return $asset;
}

/**
 * Remove path tree
 *
 * @param string $delete Path to delete
 *
 * @return bool true if directory removed
 */
function rrmdir($delete)
{
    $files = array_diff(scandir($delete), array('.', '..'));
    foreach ($files as $file) {
        (is_dir("$delete/$file")) ? rrmdir("$delete/$file") : unlink("$delete/$file");
    }

    return rmdir($delete);
}

/**
 * Checks multidimensional array for $needle.
 *
 * @param mixed $needle string oder integer to find in the haystack
 * @param array $haystack multidimensional array to recursively check for the needle
 * @param bool $strict if true the function will check the types of the needle in the haystack
 * @return bool true if the needle was found in the haystack
 */
function in_array_recursive($needle, array $haystack, bool $strict = false): bool
{
    foreach ($haystack as $item) {
        if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && in_array_recursive($needle, $item,
                    $strict))) {
            return true;
        }
    }

    return false;
}

/**
 * Translate function for the template.
 *
 * @param string $message to translate
 * @return string $translatedText
 */
function __($message)
{
    $translated = translator()->trans($message);

    return $translated;
}

/**
 * Generates a normalized URI for the given path.
 *
 * @param string $path A path to use instead of the current one
 * @param boolean $full return absolute or relative url
 *
 * @return string The normalized URI for the path
 */
function baseurl($path = '', $full = false)
{
    $scriptName = request()->server->get('SCRIPT_NAME');
    $baseUri = dirname(dirname($scriptName));
    $result = str_replace('\\', '/', $baseUri) . $path;
    $result = str_replace('//', '/', $result);
    if ($full === true) {
        $result = hosturl() . $result;
    }

    return $result;
}

/**
 * Returns current url
 *
 * @return string URL
 */
function hosturl()
{
    $server = request()->server->all();
    $host = $server['SERVER_NAME'];
    $port = $server['SERVER_PORT'];
    $result = (isset($server['HTTPS']) && $server['HTTPS'] != "off") ? "https://" : "http://";
    $result .= ($port == '80' || $port == '443') ? $host : $host . ":" . $port;

    return $result;
}

/**
 * Dispatcher.
 *
 * @param Request $request
 * @param Response $response
 * @param RouteCollection $routes
 */
function dispatch(Request $request, Response $response, RouteCollection $routes)
{
    $session = session();

    try {
        // Find matching route
        $request->attributes->set('_auth', true);

        $pathInfo = $request->getPathInfo();
        $context = new RequestContext();
        $requestContext = $context->fromRequest($request);

        $matcher = new UrlMatcher($routes, $requestContext);
        $match = $matcher->match($pathInfo);
        // Add attributes
        $request->attributes->add($match);

        // Call event
        $action = $match['_controller'];

        $parts = explode(':', $action);
        $object = new $parts[0]($request, $response, $session);
        $function = array($object, 'callAction');
        $responseNew = call_user_func_array($function, [$parts[1], $request, $response]);
        if ($responseNew instanceof Response) {
            $response = $responseNew;
        }
    } catch (Exception $ex) {
        logger("Errors-at")->error($ex->getMessage());
        $errorController = new \App\Controller\ErrorController($request, $response, $session);
        $response = $errorController->error404();
    } catch (Error $er) {
        logger("Errors-at")->error($er->getMessage());
        $errorController = new \App\Controller\ErrorController($request, $response, $session);
        $response = $errorController->error500();
    }

    if ($session && $session->isStarted()) {
        $session->save();
    }

    $response->send();
}
