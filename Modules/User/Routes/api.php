<?php

use Dingo\Api\Routing\Router;

$api = app(Router::class);
$api->version('v1', function (Router $api) {
    $api->group([
        'prefix' => 'user',
        'namespace'  => 'Modules\\User\\Http\\Controllers\\'
    ], function(Router $api) {
        $api->post('store', 'UserController@store')->middleware(['CheckToken', 'CheckAdmin']);
        $api->post('login', 'UserController@login');
        $api->get('me', 'UserController@me')->middleware('CheckToken');
        $api->get('logout', 'UserController@logout')->middleware('CheckToken');
        $api->post('lock', 'UserController@lock')->middleware(['CheckToken', 'CheckAdmin']);
        $api->post('unlock', 'UserController@unlock')->middleware(['CheckToken', 'CheckAdmin']);
        $api->get('show', 'UserController@show')->middleware(['CheckToken', 'CheckAdmin']);
        $api->get('show/{user_id}', 'UserController@showByID')->middleware(['CheckToken', 'CheckAdmin']);
        $api->get('show-user', 'UserController@showListIsUser')->middleware(['CheckToken', 'CheckAdmin']);
        $api->delete('destroy/{user_id}', 'UserController@destroy')->middleware(['CheckToken', 'CheckSuper']);
        $api->post('update/{user_id}', 'UserController@update')->middleware(['CheckToken', 'CheckSuper']);
        $api->post('update-profile', 'UserController@updateProfile')->middleware(['CheckToken']);
        $api->post('update-avatar', 'UserController@updateAvatar')->middleware(['CheckToken']);
        $api->post('reset', 'UserController@resetPassword')->middleware(['CheckToken']);
        $api->get('generate-password', 'UserController@generatePassword');
        $api->post('forgot', 'UserController@forgotPassword');
        $api->get('check-token-reset/{token}', 'UserController@checkTokenResetPassword');
        $api->post('create-new-password/{token}', 'UserController@createNewPassword');
        $api->get('test', 'UserController@test');
    });
});
