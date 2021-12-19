<?php

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/core/routes.php';
require __DIR__ . '/core/Router.php';
require __DIR__ . '/app/helpers/redirect.php';


use core\Router;

session_start();

$router = new Router();
foreach($routes as $route) {
	$router->add($route[1], $route[2], $route[0]);
}

if (is_file(__DIR__ . $_SERVER['REQUEST_URI'])) {
	return false;
}


if($_SERVER['REQUEST_URI'] != $_SERVER['SCRIPT_NAME'])
	$router->dispatch(str_replace('/Project', '', $_SERVER['REQUEST_URI']));
else 
	$router->dispatch('/');