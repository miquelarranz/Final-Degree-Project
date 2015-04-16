<?php

Route::get('/', [
    'as' => 'home',
    'uses' => 'PagesController@home'
]);

/**
 * Language
 */

Route::post('language', [
    'as' => 'language_path',
    'uses' => 'LanguageController@language'
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

/**
 * Registration
 */

Route::get('register', [
    'as' => 'register_path',
    'uses' => 'RegistrationController@create'
]);

Route::post('register', [
    'as' => 'register_path',
    'uses' => 'RegistrationController@store'
]);

/**
 * Events
 */

Route::get('events', [
    'as' => 'events_path',
    'uses' => 'EventsController@index'
]);