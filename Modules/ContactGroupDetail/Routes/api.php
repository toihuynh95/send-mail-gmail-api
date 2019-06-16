<?php

use Dingo\Api\Routing\Router;

$api = app(Router::class);
$api->version('v1', function (Router $api) {
    $api->group([
        'prefix' => 'contact-group-detail',
        'namespace'  => 'Modules\\ContactGroupDetail\\Http\\Controllers\\'
    ], function(Router $api) {
        $api->post('store', 'ContactGroupDetailController@store')->middleware(['CheckToken', 'CheckUser']);
        $api->delete('destroy/{contact_group_detail_id}', 'ContactGroupDetailController@destroy')->middleware(['CheckToken', 'CheckUser']);
        $api->get('show-by-group/{contact_group_detail_id}', 'ContactGroupDetailController@showByContactGroup')->middleware(['CheckToken', 'CheckUser']);
    });
});
