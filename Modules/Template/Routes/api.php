<?php

use Dingo\Api\Routing\Router;

$api = app(Router::class);
$api->version('v1', function (Router $api) {
    $api->group([
        'prefix' => 'template',
        'namespace'  => 'Modules\\Template\\Http\\Controllers\\'
    ], function(Router $api) {
        $api->post('store', 'TemplateController@store')->middleware(['CheckToken', 'CheckAdmin']);
        $api->post('update/{template_id}', 'TemplateController@update')->middleware(['CheckToken', 'CheckAdmin']);
        $api->delete('destroy/{template_id}', 'TemplateController@destroy')->middleware(['CheckToken', 'CheckAdmin']);
        $api->get('show', 'TemplateController@show')->middleware(['CheckToken', 'CheckAdmin']);
        $api->get('show-all', 'TemplateController@showAll')->middleware(['CheckToken', 'CheckUser']);
        $api->get('show/{template_id}', 'TemplateController@showID')->middleware(['CheckToken']);
    });
});
