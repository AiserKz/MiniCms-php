<?php 

require_once __DIR__ . '/../vendor/autoload.php';
use Core\Router;

$router = new Router();
require_once __DIR__ . '/../router/web.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();



$uri = init();
$router->dispatch($uri);