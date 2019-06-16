<?php

use Dingo\Api\Routing\Router;

$api = app(Router::class);
$api->version('v1', function (Router $api) {
    $api->group([
        'prefix' => 'contact-group',
        'namespace'  => 'Modules\\ContactGroup\\Http\\Controllers\\'
    ], function(Router $api) {
        $api->post('store', 'ContactGroupController@store')->middleware(['CheckToken', 'CheckUser']);
        $api->post('update/{contact_group_id}', 'ContactGroupController@update')->middleware(['CheckToken', 'CheckUser']);
        $api->get('show', 'ContactGroupController@show')->middleware(['CheckToken', 'CheckUser']);
        $api->delete('destroy/{contact_group_id}', 'ContactGroupController@destroy')->middleware(['CheckToken', 'CheckUser']);
        $api->get('show/{contact_group_id}', 'ContactGroupController@showID')->middleware(['CheckToken', 'CheckUser']);
        $api->get('show-active', 'ContactGroupController@showIsActive')->middleware(['CheckToken', 'CheckUser']);
        $api->get('show-all', 'ContactGroupController@showAll')->middleware(['CheckToken', 'CheckUser']);
    });
});
