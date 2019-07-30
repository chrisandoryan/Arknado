<?php

require __DIR__ . '/vendor/autoload.php';

require __DIR__ . '/App/View/Template.php';

$router = new \Bramus\Router\Router();
$view = new Template('public');

$router->setNamespace('\App\Controllers');

$router->before('GET', '/.*', function () {
	header("Access-Control-Allow-Origin: *");
});

$router->get('/api', function () use ($view) {
	print $view->render('docs');
});

$router->get('/api/swagger', function () use ($swagger)  {
	$openapi = \OpenApi\scan('App');
	header('Content-Type: application/json');
	echo $openapi->toJson();
});

$router->mount('/auth', function () use ($router) {
	$router->post('/login', 'Auth@login');
	$router->post('/register', 'Auth@register');
});

$router->mount('/ark', function () use ($router) {
	$router->post('/login', 'Auth@login');
	$router->post('/register', 'Auth@register');
});

$router->run();
