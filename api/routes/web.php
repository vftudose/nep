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

$router->get('', function () {
    return redirect()->to('/api');
});

$router->group(['prefix' => 'api'], function () use ($router) {

    $router->get('', function () use ($router) {
        return $router->app->version();
    });

    $router->post('register', 'AuthController@register');
    $router->post('authenticate', 'AuthController@authenticate');

    $router->group(['middleware' => ['auth', 'role:admin,client']], function () use ($router) {
        $router->get('/projects', 'ProjectController@index');
        $router->get('/projects/{id}', 'ProjectController@get');
        $router->patch('/tasks/{id}', 'TaskController@patch');
    });

    $router->group(['middleware' => ['auth', 'role:admin']], function () use ($router) {
        $router->post('/projects', 'ProjectController@store');
        $router->post('/tasks', 'TaskController@store');
        $router->get('/users', 'UserController@index');
    });
});

