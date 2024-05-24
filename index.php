<?php

require_once __DIR__ . '/vendor/autoload.php';

use Slim\Factory\AppFactory;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Dotenv\Dotenv;
use Slim\Routing\RouteCollectorProxy;
use Mark\Controllers\CommentController;
use Mark\Controllers\NewsController;
use Mark\Services\NewsService;
use Mark\Services\CommentService;
use Mark\Libraries\Database;

// Load environment variables
$dotenv = Dotenv::createImmutable(__DIR__);
$loaded = $dotenv->load();

if (!$loaded) {
    die('.env file could not be loaded.');
}

// // Create a DI container
// $container = new \DI\Container();

// // Set up dependencies in the container
// $container->set(Database::class, function () {
//     return Database::getInstance();
// });

// // Set up dependencies in the container
// $container->set(NewsService::class, function ($container) {
//     $database = $container->get(Database::class);
//     return new NewsService($database);
// });

// // Set up dependencies in the container
// $container->set(CommentService::class, function ($container) {
//     $database = $container->get(Database::class);
//     return new CommentService($database);
// });

// // Instantiate the Slim App with the container
// AppFactory::setContainer($container);
// $app = AppFactory::create();

// // Define routes
// $app->get('/', function (Request $request, Response $response, $args) {
//     $response->getBody()->write('PHP Version ' . phpversion());
//     return $response;
// });

// // Inject dependency into the /news route
// $app->get('/news', function (Request $request, Response $response) {
//     $service = $this->get(NewsService::class);
//     $newsController = new NewsController($service);
//     return $newsController->listNews($request, $response);
// });

// // Use dependency injection in the /comments route
// $app->get('/comments', function (Request $request, Response $response) {
//     $service = $this->get(CommentService::class);
//     $commentController = new CommentController($service);
//     return $commentController->listComments($request, $response);
// });

// Run the Slim App
$app->run();
