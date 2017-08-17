<?php

use Cake\Database\Connection;
use Cake\Database\Driver\Mysql;
use League\Plates\Engine;
use Monolog\Logger;
use Monolog\Handler\RotatingFileHandler;
use Odan\Config\ConfigBag;
use Odan\Plates\Extension\PlatesDataExtension;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage;
use Symfony\Component\HttpFoundation\Session\Storage\Handler\NativeFileSessionHandler;
use Symfony\Component\Translation\Translator;
use Symfony\Component\Translation\MessageSelector;
use Symfony\Component\Translation\Loader\MoFileLoader;
use Symfony\Component\Routing\Route;

function container()
{
    static $container = null;
    if ($container === null) {
        $container = new ParameterBag();
    }
    return $container;
}

/**
 * Get Translator Object.
 *
 * @return Translator
 */
function translator()
{
    $translator = container()->get('translator');
    if (!$translator) {
        $session = session();
        $locale = $session->get('lang');
        if (empty($locale)) {
            $locale = "en_US";
            $session->set('lang', "en_US");
        }
        $resource = __DIR__ . "/../resources/locale/" . $locale . "_messages.mo";
        $translator = new Translator($locale, new MessageSelector());
        $translator->setFallbackLocales(array('en_US'));
        $translator->addLoader('mo', new MoFileLoader());
        $translator->addResource('mo', $resource, $locale);
        $translator->setLocale($locale);
        container()->set('translator', $translator);
    }
    return $translator;
}

/**
 * Get Request object.
 *
 * @return Request
 */
function request()
{
    $request = container()->get('request');
    if (!$request) {
        $request = Request::createFromGlobals();
        container()->set('request', $request);
    }
    return $request;
}

/**
 * Get Response object.
 *
 * @return Response $response !null
 */
function response()
{
    $response = container()->get('response');
    if (!$response) {
        $response = new Response('', 200);
        container()->set('response', $response);
    }
    return $response;
}

/**
 * Route function.
 *
 * @param $methods
 * @param $path
 * @param $controller
 *
 * @return Route
 */
function route($methods, $path, $controller)
{
    return new Route(baseurl($path), ['_controller' => $controller], [], [], '', [], (array)$methods);
}

/**
 * Start session.
 *
 * @return Session
 */
function session()
{
    $session = container()->get('session');
    if (!$session) {
        $storage = new NativeSessionStorage(array(), new NativeFileSessionHandler());
        $session = new Session($storage);
        container()->set('session', $session);
    }
    return $session;
}

/**
 * Write log.
 *
 * If an exception was catched, this function will be executed.
 * The function writes the message in the error.log file.
 *
 * @param string $file for the filename
 *
 * @return Logger
 */
function logger($file)
{
    $logger = new Logger('app');
    $logFile = __DIR__ . "/../tmp/logs/$file.txt";
    $handler = new RotatingFileHandler($logFile, 0, Logger::DEBUG, true, 0775);
    $logger->pushHandler($handler);
    return $logger;
}

/**
 * Set Mail settings.
 *
 * @link https://github.com/PHPMailer/PHPMailer
 * @return PHPMailer properties
 */
function mailer()
{
    $mailer = container()->get('mailer');
    if (!$mailer) {
        $config = config()->get("mail");
        $mailer = new \PHPMailer();
        $mailer->isSMTP();
        $mailer->SMTPDebug = 0;
        $mailer->Host = $config['host'];
        $mailer->Port = $config['port'];
        $mailer->Username = $config['username'];
        $mailer->Password = $config['password'];
        $mailer->CharSet = $config['charset'];
        $mailer->SMTPAuth = true;
        $mailer->SMTPSecure = 'tls';
        $mailer->Timeout = 10;
        container()->set('mailer', $mailer);
    }
    return $mailer;
}

/**
 * Get or set config options
 *
 * @return \Odan\Config\ConfigBag
 */
function config()
{
    $config = container()->get('config');
    if (!$config) {
        $config = new ConfigBag();
        container()->set('config', $config);
    }
    return $config;
}


/**
 * Create a connection to a database.
 *
 * @return Connection
 */
function db()
{
    $db = container()->get('db');
    if (!$db) {
        $config = config()->get("db");
        $driver = new Mysql([
            'host' => $config['host'],
            'port' => $config['port'],
            'database' => $config['database'],
            'username' => $config['username'],
            'password' => $config['password'],
            'encoding' => $config['encoding'],
            'charset' => $config['charset'],
            'collation' => $config['collation'],
            'prefix' => '',
            'flags' => [
                // Enable exceptions
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                // Set default fetch mode
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_PERSISTENT => false,
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8 COLLATE utf8_unicode_ci"
            ]
        ]);
        $db = new Connection([
            'driver' => $driver
        ]);
        $db->connect();
        container()->set('db', $db);
    }
    return $db;
}

/**
 * View function.
 *
 * @return Engine
 */
function view()
{
    $engine = container()->get('engine');
    if (!$engine) {
        $config = config();
        $viewPath = $config->get('viewPath');
        $engine = new Engine($viewPath, null);
        $engine->loadExtension(new PlatesDataExtension());

        $engine->addFolder('view', $config->get("viewPath"));
        $engine->addFolder('css', $config->get("publicCssPath"));
        $engine->addFolder('js', $config->get("publicJsPath"));
        container()->set('engine', $engine);
    }
    return $engine;
}
