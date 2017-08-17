<?php
/**
 * This file is the env File
 */
// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', '1');

$env = array();
$env['db']['database'] = '';
$env['db']['username'] = '';
$env['db']['password'] = '';

return $env;
