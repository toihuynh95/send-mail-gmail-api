<?php

use Dingo\Api\Routing\Router;

$api = app(Router::class);
$api->version('v1', function (Router $api) {
    $api->group([
        'prefix' => 'campaign',
        'namespace'  => 'Modules\\Campaign\\Http\\Controllers\\'
    ], function(Router $api) {
        $api->post('store', 'CampaignController@store')->middleware(['CheckToken', 'CheckUser']);
        $api->post('update/{campaign_id}', 'CampaignController@update')->middleware(['CheckToken', 'CheckUser']);
        $api->get('show', 'CampaignController@show')->middleware(['CheckToken', 'CheckUser']);
        $api->get('show/{campaign_id}', 'CampaignController@showID')->middleware(['CheckToken', 'CheckUser']);
    });

    $api->group([
        'prefix' => 'campaign-log',
        'namespace'  => 'Modules\\Campaign\\Http\\Controllers\\'
    ], function(Router $api) {
        $api->get('show/{campaign_id}', 'CampaignController@showLog')->middleware(['CheckToken', 'CheckUser']);
        $api->get('count-send/{campaign_id}', 'CampaignController@countSend')->middleware(['CheckToken', 'CheckUser']);
    });
});
