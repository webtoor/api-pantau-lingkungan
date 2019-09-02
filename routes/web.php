<?php

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
$router->get('storage/{image_name}',['uses' => 'UserController@showImage']);
$router->post('register', ['uses' => 'AuthController@register']);
$router->post('login', ['uses' => 'AuthController@login']);

$router->get('testfile',[ 'uses' => 'UserController@writeFile'
]);
$router->get('file',[ 'uses' => 'UserController@readFile'
]);
$router->group(['prefix' => 'api/v1', 'middleware' => ['auth:api']], function () use ($router) {
    $router->group(['prefix' => 'user'], function () use ($router) {
    $router->post('lapor', ['uses' => 'UserController@createLaporan']);
    });
});