<?php
/**
 * This file is the config File
 *
 * @author  Björn Pfoster
 */
// Error reporting
error_reporting(0);
ini_set('display_errors', '0');

// Timezone
date_default_timezone_set('Europe/Berlin');

$bag = config();

$config = array();

$config['oauth']['server'] = '';
$config['assets']['cachePath'] = __DIR__ . '/../tmp/cache/';
$config['assets']['minimize'] = false;

// Database settings
// insertUser data here
// TODO insert database data
$config['db']['host'] = '127.0.0.1';
$config['db']['port'] = '3306';
// in env.php
$config['db']['database'] = '';
$config['db']['username'] = '';
$config['db']['password'] = '';
$config['db']['charset'] = 'utf8';
$config['db']['encoding'] = 'utf8';
$config['db']['collation'] = 'utf8_unicode_ci';
$config['db']['migrationsPath'] = __DIR__ . '/../resources/migrations';

// Test Database settings
// insert User data here
// TODO insert database data
$config['db_test']['host'] = '127.0.0.1';
$config['db_test']['port'] = '3306';
// in env.php
$config['db_test']['database'] = '';
$config['db_test']['username'] = '';
$config['db_test']['password'] = '';
$config['db_test']['charset'] = 'utf8';
$config['db_test']['encoding'] = 'utf8';
$config['db_test']['collation'] = 'utf8_unicode_ci';
$config['db_test']['migrationsPath'] = __DIR__ . '/../resources/migrations';

$config['viewPath'] = __DIR__ . '/../src/View';
$config['publicCssPath'] = __DIR__ . '/../public/css';
$config['publicJsPath'] = __DIR__ . '/../public/js';

$config['routes'] = $bag->read(__DIR__ . '/routes.php');

if (file_exists(__DIR__ . '/../../env.php')) {
    $env = $bag->read(__DIR__ . '/../../env.php');
} elseif (file_exists(__DIR__ . '/env.php')) {
    $env = $bag->read(__DIR__ . '/env.php');
} else {
    throw new Exception('env.php not found');
}

// Merge data from env.php and config.
$bag->import($config);
$bag->import($env);
