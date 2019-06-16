<?php

use Dingo\Api\Routing\Router;

$api = app(Router::class);
$api->version('v1', function (Router $api) {
    $api->group([
        'prefix' => 'project',
        'namespace'  => 'Modules\\Project\\Http\\Controllers\\'
    ], function(Router $api) {
        $api->post('store', 'ProjectController@store')->middleware(['CheckToken', 'CheckAdmin']);
        $api->post('update/{project_id}', 'ProjectController@update')->middleware(['CheckToken', 'CheckAdmin']);
        $api->delete('destroy/{project_id}', 'ProjectController@destroy')->middleware(['CheckToken', 'CheckAdmin']);
        $api->get('show/{project_id}', 'ProjectController@showID')->middleware(['CheckToken', 'CheckAdmin']);
        $api->get('show', 'ProjectController@show')->middleware(['CheckToken', 'CheckAdmin']);
        $api->get('show-by-customer-current', 'ProjectController@showByCustomerCurrent')->middleware(['CheckToken', 'CheckUser']);
        $api->get('show-list', 'ProjectController@showList')->middleware(['CheckToken', 'CheckUser']);
        $api->get('check-contact_group/{project_id}/{contact_group_id}', 'ProjectController@checkProjectContactGroup')->middleware(['CheckToken', 'CheckUser']);
    });
});
