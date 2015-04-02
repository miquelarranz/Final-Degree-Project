<?php

Route::get('/', [
    'as' => 'home',
    'uses' => 'PagesController@home'
]);

/**
 * Sessions
 */

Route::get('login', [
    'as' => 'login_path',
    'uses' => 'SessionsController@create'
]);

Route::post('login', [
    'as' => 'login_path',
    'uses' => 'SessionsController@store'
]);

Route::get('logout', [
    'as' => 'logout_path',
    'uses' => 'SessionsController@destroy'
]);