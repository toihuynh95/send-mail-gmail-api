<?php

use Dingo\Api\Routing\Router;

$api = app(Router::class);
$api->version('v1', function (Router $api) {
    $api->group([
        'prefix' => 'contact',
        'namespace'  => 'Modules\\Contact\\Http\\Controllers\\'
    ], function(Router $api) {
        $api->post('store', 'ContactController@store')->middleware(['CheckToken', 'CheckUser']);
        $api->post('import', 'ContactController@import')->middleware(['CheckToken', 'CheckUser']);
        $api->get('export', 'ContactController@export')->middleware(['CheckToken', 'CheckUser']);
        $api->post('update/{contact_id}', 'ContactController@update')->middleware(['CheckToken', 'CheckUser']);
        $api->get('show', 'ContactController@show')->middleware(['CheckToken', 'CheckUser']);
        $api->get('show-except-in-group/{contact_group_id}', 'ContactController@showExceptInGroup')->middleware(['CheckToken', 'CheckUser']);
        $api->get('show/{contact_id}', 'ContactController@showID')->middleware(['CheckToken', 'CheckUser']);
        $api->delete('destroy/{contact_id}', 'ContactController@destroy')->middleware(['CheckToken', 'CheckUser']);
    });
});
