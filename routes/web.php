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

/** @var \Laravel\Lumen\Routing\Router $router */

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'api'], function () use ($router) {

    $router->group(['prefix' => 'v1', 'middleware' => 'cors'], function () use ($router) {

        $router->post('login', 'AuthController@login')
            ->post('logout', 'AuthController@logout');

        $router->group(['prefix' => 'operations', 'middleware' => 'auth'], function () use ($router) {

            $router->get('/', 'OperationController@all')
                ->post('/', 'OperationController@create')
                ->put('/{id}', 'OperationController@update')
                ->delete('/{id}', 'OperationController@delete');

        });

        $router->get('balance', [
            'middleware' => 'auth',
            'uses' => 'BalanceController@balance',
        ]);

    });

});