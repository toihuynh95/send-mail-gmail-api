<?php

use Dingo\Api\Routing\Router;

$api = app(Router::class);
$api->version('v1', function (Router $api) {
    $api->group([
        'prefix' => 'mailing-service',
        'namespace'  => 'Modules\\MailingService\\Http\\Controllers\\'
    ], function(Router $api) {
        $api->post('store', 'MailingServiceController@store')->middleware(['CheckToken', 'CheckAdmin']);
        $api->post('update/{mailing_service_id}', 'MailingServiceController@update')->middleware(['CheckToken', 'CheckAdmin']);
        $api->delete('destroy/{mailing_service_id}', 'MailingServiceController@destroy')->middleware(['CheckToken', 'CheckAdmin']);
        $api->get('show', 'MailingServiceController@show')->middleware(['CheckToken', 'CheckAdmin']);
        $api->get('show-all', 'MailingServiceController@showAll')->middleware(['CheckToken', 'CheckAdmin']);
        $api->get('show/{mailing_service_id}', 'MailingServiceController@showID')->middleware(['CheckToken', 'CheckAdmin']);
    });
});
