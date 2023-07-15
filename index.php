<?php
require_once "lib/AltoRouter.php";
include_once "services.php";

$router = new AltoRouter();

// Config
$_SESSION['title']= "EMP Manager";

// VIEW GROUPS
$router->map('GET', '/', function() {
    require __DIR__ . '/views/login.php';
});

$router->map('GET', '/login', function() {
    require __DIR__ . '/views/login.php';
});

$router->map('GET', '/admin', function() {
    require __DIR__ . '/views/admin.php';
});

// API GROUPS
$router->map('POST', '/api/oauth/login', function() use ($router) {
    header('Content-Type: application/json');
    return call_user_func_array([new Services(), 'login'], []);
});

$router->map('GET', '/api/oauth/logout', function() use ($router) {
    header('Content-Type: application/json');
    return call_user_func_array([new Services(), 'logout'], []);
});

$router->map('POST', '/api/employee', function() use ($router) {
    header('Content-Type: application/json');
    return call_user_func_array([new Services(), 'createEmployee'], []);
});

$router->map('GET', '/api/employee/list', function() use ($router) {
    header('Content-Type: application/json');
    return call_user_func_array([new Services(), 'getEmployee'], []);
});

$router->map('PUT', '/api/employee/[i:id]', function($id) use ($router) {
    header('Content-Type: application/json');
    return call_user_func_array([new Services(), 'updateEmployee'], [$id]);
});

$router->map('DELETE', '/api/employee/[i:id]', function($id) use ($router) {
    header('Content-Type: application/json');
    return call_user_func_array([new Services(), 'deleteEmployee'], [$id]);
});

// match current request url
$match = $router->match();

// call closure or throw 404 status
if (is_array($match) && is_callable($match['target'])) {
    // Pass the matched parameters to the closure function
    call_user_func_array($match['target'], $match['params']);
} else {
    // No route was matched
    require __DIR__ . '/views/404.php';
}
