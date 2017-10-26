<?php
$pagename = readline("Please enter the new page name: ");

$case0 = strpos($pagename, ' ') !== false;
$case1 = strpos($pagename, '_') !== false;
$case2 = strpos($pagename, '-') !== false;
switch ($pagename) {
    case $case0:
        $parts = explode(' ', $pagename);
        break;
    case $case1:
        $parts = explode('_', $pagename);
        break;
    case $case2:
        $parts = explode('-', $pagename);
        break;
    default:
        $parts = [$pagename];
        break;
}

$lowerCase = [];
foreach ($parts as $key => $part) {
    $parts[$key] = ucfirst(strtolower($part));
    $lowerCase[] = strtolower($part);
}
$pageNameMinusSeparated = implode('-', $lowerCase);

$pagename = implode('', $parts);

$controllerpath = __DIR__ . '/../src/Controller/';
$templatePath = __DIR__ . '/../src/View/' . $pagename;

echo "Creating directory " . $templatePath . "\n";
if (!is_dir($templatePath)) {
    mkdir($templatePath);
} else {
    echo "Directory already exists\ncontinuing . . .\n";
}

$htmlfile = $pageNameMinusSeparated . '.html.php';
echo "Creating HTML File " . $htmlfile . "\n";
$html = "<?php \$this->layout('view::Layout/layout.html.php');?>\n";
file_put_contents($templatePath . '/' . $htmlfile, $html);
$isApiController = ask('Is the Controller an API Controller? [y/n]');
$controllername = $pagename . 'Controller';
$controllerfile = $controllername . '.php';
echo "Creating controller: " . $controllername . "\n";
$namespace = 'App\Controller\\' . $isApiController ? 'Api\\' : '' . $controllername;
$code = "<?php\n\nnamespace " . $namespace . ";\n\n" . $isApiController ? "use App\Controller\AppController;\n\n" : "" . "use Symfony\Component\HttpFoundation\Response;\n\nclass " . $controllername . " extends AppController\n{\n\t/** Index function\n\t *\n\t * @return Response\n\t */\n\tpublic function index()\n\{\n\t\t//TODO insert code here\n\t}\n}\n";
file_put_contents($controllerpath . $controllerfile, $code);
$routeCorrect = false;
do {
    $routeName = readline("Please insert a route for the Controller (like /users). \nFor further information please visit https://symfony.com/doc/current/routing.html: ");
    $routeCorrect = ask('Is your route (' . $routeName . ') correct? [y/n] ');
} while (!$routeCorrect);

$methodsCorrect = false;
do {
    $methods = readline('Please insert a commaseparated list of HTTP Methods for this route: [GET, POST, PUT, DELETE, OPTIONS, HEAD] ');
    $methodsCorrect = ask('Are your methods (' . $methods . ') correct? [y/n] ');
} while (!$methodsCorrect);

$methods = explode(',', $methods);
foreach ($methods as $key => $method) {
    $methods[$key] = trim($method);
}
$m = $methods;
$methods = '[' . implode(',', $methods) . ']';

$routes = file_get_contents(__DIR__ . '/../config/routes.php');
$routes = str_replace('return $routes;', '', $routes);
$routes .= "\n\n\$route->->add('/" . $routeName . "_" . implode('_',
        $m) . "',route(" . $methods . ", '" . $routeName . "', ['" . $namespace . $controllername . "', 'index']));\n\nreturn \$routes;";
$handle = fopen(__DIR__ . '/../config/routes.php', 'w+');
fwrite($handle, $routes);
fclose($handle);

function ask($message): bool
{
    do {
        $condition = readline($message);
        if (strtolower($condition) === 'y') {
            $condition = true;
        } else {
            if (strtolower($condition) === 'n') {
                $condition = false;
            }
        }
    } while (!is_bool($condition));
    return $condition;
}