<?php
use App\Controllers;

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/App/Controllers/UserController.php';
require __DIR__ . '/App/Controllers/ArkController.php';
require __DIR__ . '/App/Controllers/ShowdownController.php';
require __DIR__ . '/App/View/Template.php';

$router = new \Bramus\Router\Router();
$view = new Template('public');

$userController = new App\Controllers\UserController();
$arkController = new App\Controllers\ArkController();

// $router->setNamespace('\App\Controllers');

$router->before('GET|POST|PUT', '/.*', function () {
	header("Access-Control-Allow-Origin: *");
});

$router->get('/api', function () use ($view) {
	print $view->render('docs');
});

$router->get('/api/swagger', function () {
	$openapi = \OpenApi\scan('App');
	header('Content-Type: application/json');
	echo $openapi->toJson();
});

$router->mount('/user', function () use ($router, $userController) {
	$router->post('/login', function () use ($userController) {
		$raw = file_get_contents('php://input');
		$response = $userController->login($raw);

		if ($response['status'] === "success") {
			http_response_code(200);
		}
		else if ($response['status'] === "failed") {
			http_response_code(400);
		}
		echo json_encode($response);
	});
	$router->post('/register', function () use ($userController) {
		$raw = file_get_contents('php://input');
		$response = $userController->register($raw);

		if ($response['status'] === "success") {
			http_response_code(200);
		}
		else if ($response['status'] === "failed") {
			http_response_code(400);
		}
		echo json_encode($response);
	});
});

$router->mount('/ark', function () use ($router, $arkController) {
	$router->post('/create', function () use ($arkController) {
		$raw = file_get_contents('php://input');
		$response = $arkController->insertArk($raw);

		if ($response['status'] === "success") {
			http_response_code(200);
		}
		else if ($response['status'] === "failed") {
			http_response_code(400);
		}
		echo json_encode($response);
	});
	$router->get('/upgrade/(\d+)', function ($id) use ($arkController) {
		$response = $arkController->upgradeArk($id, $_GET);

		if ($response['status'] === "success") {
			http_response_code(200);
		}
		else if ($response['status'] === "failed") {
			http_response_code(400);
		}
		echo json_encode($response);
	});
	$router->post('/(\d+)/uploadBanner', function ($id) use ($arkController) {
		$response = $arkController->uploadBanner($id, $_FILES);

		if ($response['status'] === "success") {
			http_response_code(200);
		}
		else if ($response['status'] === "failed") {
			http_response_code(400);
		}
		echo json_encode($response);
	});
});

$router->get('/arks', function () use ($arkController) {
	$response = $arkController->getArks($_GET);

	if ($response['status'] === "success") {
		http_response_code(200);
	}
	else if ($response['status'] === "failed") {
		http_response_code(400);
	}
	echo json_encode($response);
});

$router->run();
