<?php

use Dingo\Api\Routing\Router;

$api = app(Router::class);
$api->version('v1', function (Router $api) {
    $api->group([
        'prefix' => 'statistic',
        'namespace'  => 'Modules\\Statistic\\Http\\Controllers\\'
    ], function(Router $api) {
        $api->post('view-by-month-total', 'StatisticController@viewByMonthTotal');
        $api->post('view-by-month-detail', 'StatisticController@viewByMonthDetail');
        $api->post('report', 'StatisticController@report');
    });
});
