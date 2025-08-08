<?php 

  
require_once __DIR__ . '/../vendor/autoload.php';


use Core\Router;

$uri = init();
$router = new Router();



$router->get('/', 'HomeController@index');
$router->get('/about', 'HomeController@about');
$router->get('/post/{id}', 'PostController@show');
$router->get('/new-post', 'PostController@create', ['middleware' => ['auth']]);
$router->post('/new-post', 'PostController@newPost');

$router->get('/post/update/{id}', 'PostController@updateForm', ['middleware' => ['auth']]);
$router->post('/post/update/{id}', 'PostController@update');

$router->get('/post/delete/{id}', 'PostController@delete', ['middleware' => ['auth']]);

$router->post('/post/add-comment', 'CommentsController@newComment', ['middleware' => ['auth']]);

$router->get('/login', 'AuthController@index', ['middleware' => 'guest']);
$router->get('/logout', 'AuthController@logout');
$router->post('/login', 'AuthController@login');
$router->post('/register', 'AuthController@register');

$router->get('/dasboard', 'AdminController@index', ['middleware' => ['auth', 'admin']]);


$router->dispatch($uri);