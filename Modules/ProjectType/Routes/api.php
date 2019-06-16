<?php

use Dingo\Api\Routing\Router;

$api = app(Router::class);
$api->version('v1', function (Router $api) {
    $api->group([
        'prefix' => 'project-type',
        'namespace'  => 'Modules\\ProjectType\\Http\\Controllers\\'
    ], function(Router $api) {
        $api->post('store', 'ProjectTypeController@store')->middleware(['CheckToken', 'CheckAdmin']);
        $api->post('update/{project_type_id}', 'ProjectTypeController@update')->middleware(['CheckToken', 'CheckAdmin']);
        $api->delete('destroy/{project_type_id}', 'ProjectTypeController@destroy')->middleware(['CheckToken', 'CheckAdmin']);
        $api->get('show', 'ProjectTypeController@show')->middleware(['CheckToken', 'CheckAdmin']);
        $api->get('show-all', 'ProjectTypeController@showAll')->middleware(['CheckToken', 'CheckAdmin']);
        $api->get('show/{project_type_id}', 'ProjectTypeController@showID')->middleware(['CheckToken', 'CheckAdmin']);
    });
});
