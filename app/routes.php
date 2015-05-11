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

Route::get('event/{id}', [
    'as' => 'event_path',
    'uses' => 'EventsController@show'
]);

Route::post('filter', [
    'as' => 'filter_path',
    'uses' => 'EventsController@filter'
]);

Route::get('download/{id}', [
    'as' => 'event_download_path',
    'uses' => 'EventsController@download'
]);

/**
 * Integration System testing
 */

Route::get('reader', [
    'as' => 'integration_path',
    'uses' => 'IntegrationController@reader'
]);

Route::get('clean', [
    'as' => 'clean_path',
    'uses' => 'IntegrationController@clean'
]);

/**
 * Profile
 */

Route::get('profile', [
    'as' => 'profile_path',
    'uses' => 'ProfileController@show'
]);

Route::get('profile/modify', [
    'as' => 'profile_modify_path',
    'uses' => 'ProfileController@create'
]);

Route::post('profile/modify', [
    'as' => 'profile_modify_path',
    'uses' => 'ProfileController@store'
]);

Route::get('profile/delete', [
    'as' => 'profile_delete_path',
    'uses' => 'ProfileController@delete'
]);

/**
 * Google
 */

Route::get('login/google', [
    'as' => 'google_login_path',
    'uses' => 'GoogleController@login'
]);

Route::post('addEvent', [
    'as' => 'add_event_path',
    'uses' => 'GoogleController@addEvent'
]);