<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

$app->group(['namespace' => 'App\Http\Controllers'], function($group) use($app) {

    $app->get('/admin/users', 'AdminUserController@index');
    $app->post('/admin/users', 'AdminUserController@store');
    $app->get('/admin/users/{users}', 'AdminUserController@show');
    $app->patch('/admin/users/{users}', 'AdminUserController@update');
    $app->delete('/admin/users/{users}', 'AdminUserController@destroy');

    $app->get('/users', 'UserController@index');



    $group->get('/', function () use ($app) {
        return view()->make('client');
    });

    $group->post('login', function () use ($app) {
        $username = app()->make('request')->input("email");
        $password = app()->make('request')->input("password");
        return $app->make('App\Auth\Proxy')->attemptLogin(["username" => $username, "password" => $password]);
    });

    $group->post('refresh-token', function () use ($app) {
        return $app->make('App\Auth\Proxy')->attemptRefresh();
    });

    $group->post('oauth/access-token', function () use ($app) {
        return response()->json($app->make('oauth2-server.authorizer')->issueAccessToken());
    });

});






