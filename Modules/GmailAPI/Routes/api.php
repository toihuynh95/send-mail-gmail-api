<?php

use Dingo\Api\Routing\Router;

$api = app(Router::class);
$api->version('v1', function (Router $api) {
    $api->group([
        'prefix' => 'google',
        'namespace'  => 'Modules\\GmailAPI\\Http\\Controllers\\'
    ], function(Router $api) {
        $api->get('auth', 'GoogleGetTokenController@getAuthCode');
        $api->get('token', 'GoogleGetTokenController@getToken');
    });
});
