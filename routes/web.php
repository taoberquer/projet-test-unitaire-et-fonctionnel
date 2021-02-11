<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->get('/user', 'UserController@index');
$router->post('/user', 'UserController@create');
$router->get('/user/{userID}', 'UserController@show');
$router->delete('/user{userID}', 'UserController@delete');

$router->post('/user{userID}/todolist', 'ToDoListController@create');

$router->post('/todolist/{toDoListID}/item/', 'ItemController@addItem');
$router->post('/item/{itemID}', 'ItemController@removeItem');
