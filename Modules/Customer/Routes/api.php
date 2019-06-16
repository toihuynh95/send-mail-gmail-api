<?php

use Dingo\Api\Routing\Router;

$api = app(Router::class);
$api->version('v1', function (Router $api) {
    $api->group([
        'prefix' => 'customer',
        'namespace'  => 'Modules\\Customer\\Http\\Controllers\\'
    ], function(Router $api) {
        $api->get('show', 'CustomerController@show')->middleware(['CheckToken', 'CheckAdmin']);
        $api->get('show-all', 'CustomerController@showAll')->middleware(['CheckToken', 'CheckAdmin']);
        $api->post('update-personal-info', 'CustomerController@updatePersonalInfo')->middleware(['CheckToken', 'CheckUser']);
        $api->get('show-personal-info', 'CustomerController@showPersonalInfo')->middleware(['CheckToken', 'CheckUser']);
    });
});
