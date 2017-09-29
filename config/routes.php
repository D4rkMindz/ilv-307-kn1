<?php

use Symfony\Component\Routing\RouteCollection;

$routes = new RouteCollection();

/**
 * Index
 */
$routes->add('/index_get', route('GET', '/', 'App\Controller\IndexController:index'));
$routes->get('/index_get')->addDefaults(['_auth' => false]);

/**
 * Error
 */
$routes->add('/error_get', route('GET', '/error-{errorcode}', 'App\Controller\ErrorController:index'));
$routes->get('/error_get')->setRequirements(['errorcode' => '\d+']);
$routes->get('/error_get')->addDefaults(['_auth' => false]);

/**
 * Language
 */
$routes->add('/language', route('GET', '/language', 'App\Controller\LanguageController:language'));
$routes->get('/language')->addDefaults(['_auth' => false]);

/**
 * Users
 */
$routes->add('/users_get', route('GET', '/users', 'App\Controller\Api\UserController:getUsers'));

$routes->add('/users_post', route(['POST', 'OPTIONS'], '/users', 'App\Controller\Api\UserController:addUser'));

$routes->add('/user_get_id', route('GET', '/users/{user_id}', 'App\Controller\Api\UserController:getUser'));
$routes->get('/user_get_id')->setRequirements(['user_id' => '\d+']);

$routes->add('/users_update', route(['POST', 'OPTIONS'], '/users/{user_id}/put', 'App\Controller\Api\UserController:updateUser'));
$routes->get('/users_update')->setRequirements(['user_id' => '\d+']);

$routes->add('/users_delete', route(['POST', 'OPTIONS'], '/users/{user_id}/del', 'App\Controller\Api\UserController:deleteUser'));
$routes->get('/users_delete')->setRequirements(['user_id' => '\d+']);

/**
 * Tasks
 */
$routes->add('/tasks_get', route('GET', '/users/{user_id}/tasks', 'App\Controller\Api\TaskController:getTasks'));
$routes->get('/tasks_get')->setRequirements(['user_id' => '\d+']);

$routes->add('/tasks_post', route(['POST', 'OPTIONS'], '/tasks', 'App\Controller\Api\TaskController:addTask'));

$routes->add('/tasks_update',
    route(['PUT', 'OPTIONS'], '/users/{user_id}/tasks/{task_id}', 'App\Controller\Api\TaskController:updateTask'));
$routes->get('/tasks_update')->setRequirements(['user_id' => '\d+', 'task_id' => '\d+']);

$routes->add('/tasks_delete',
    route(['DELETE', 'OPTIONS'], '/users/{user_id}/tasks/{task_id}', 'App\Controller\Api\TaskController:deleteTask'));
$routes->get('/tasks_delete')->setRequirements(['user_id' => '\d+', 'task_id' => '\d+']);

$routes->add('/tasks_get_id',
    route('GET', '/users/{user_id}/tasks/{task_id}', 'App\Controller\Api\TaskController:getTask'));
$routes->get('/tasks_get_id')->setRequirements(['user_id' => '\d+', 'task_id' => '\d+']);

/**
 * Allocate Tasks
 */
$routes->add('/tasks_allocate',
    route(['POST', 'OPTIONS'], '/users/{user_id}/tasks/{task_id}/allocate', 'App\Controller\Api\TaskController:allocateTask'));
$routes->get('/tasks_allocate')->setRequirements(['user_id' => '\d+', 'task_id' => '\d+']);

$routes->add('/tasks_deallocate',
    route(['DELETE', 'OPTIONS'], '/users/{user_id}/tasks/{task_id}/deallocate', 'App\Controller\Api\TaskController:deallocateTask'));
$routes->get('/tasks_deallocate')->setRequirements(['user_id' => '\d+', 'task_id' => '\d+']);

/**
 * Authorization
 */
$routes->add('/authorize_add',
    route(['POST', 'OPTIONS'], '/authorize', 'App\Controller\Api\AuthorizationController:getAuth'));
$routes->get('/authorize_add')->addDefaults(['_auth' => false]);

return $routes;
