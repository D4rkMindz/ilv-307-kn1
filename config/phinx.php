<?php
require_once __DIR__ . "/bootstrap.php";

$db = db();
$config = config();
$db->getDriver()->connect();
$pdo = $db->getDriver()->connection();

return array(
    'paths' => array(
        'migrations' => $config->get("db.migrationsPath"),
    ),
    'environments' => array(
        'default_database' => 'local',
        'local' => array(
            'name' => $config->get("db.database"),
            'connection' => $pdo,
        ),
    ),
);
