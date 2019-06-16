<?php

Route::prefix('user')->group(function() {
    Route::get('/','UserController@index');
    Route::get('/login','UserController@login');
    Route::get('/profile','UserController@profile');
});

Route::prefix('customer')->group(function() {
    Route::get('/','CustomerController@index');
});

Route::prefix('contact')->group(function() {
    Route::get('/','ContactController@index');
});

Route::prefix('project')->group(function (){
   Route::get('/','ProjectController@index');
   Route::get('/me','ProjectController@me');
});
Route::prefix('template')->group(function (){
    Route::get('/','TemplateController@index');
});
Route::prefix('campaign')->group(function (){
    Route::get('/','CampaignController@index');
});

Route::prefix('setting')->group(function() {
    Route::get('/','SettingController@index');
});

Route::prefix('dashboard')->group(function() {
    Route::get('/','StatisticController@index');
});



