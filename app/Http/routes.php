<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', ['as' => 'home', 'uses' => 'HomeController@index']);
Route::get('/u/{id}', ['as' => 'unsubscribe', 'uses' => 'EmailController@unsubscribe']);

Route::get('/tags', ['as' => 'tags.index', 'uses' => 'TagsController@index']);
Route::get('/emails', ['as' => 'emails.index', 'uses' => 'EmailController@index']);

Route::get('/settings', ['as' => 'settings.index', 'uses' => 'SettingsController@index']);
Route::get('/settings/add', ['as' => 'settings.add', 'uses' => 'SettingsController@add']);
Route::get('/settings/{id}/edit', ['as' => 'settings.edit', 'uses' => 'SettingsController@edit']);
Route::post('/settings/{id}/edit', ['as' => 'settings.update', 'uses' => 'SettingsController@update']);
Route::post('/settings/add', ['as' => 'settings.create', 'uses' => 'SettingsController@create']);

Route::get('/sites', ['as' => 'sites.index', 'uses' => 'SitesController@index']);
Route::get('/sites/add', ['as' => 'sites.add', 'uses' => 'SitesController@add']);
Route::get('/sites/{id}/edit', ['as' => 'sites.edit', 'uses' => 'SitesController@edit']);
Route::get('/sites/{id}/delete', ['as' => 'sites.delete', 'uses' => 'SitesController@delete']);
Route::post('/sites/{id}/edit', ['as' => 'sites.update', 'uses' => 'SitesController@update']);
Route::post('/sites/add', ['as' => 'sites.create', 'uses' => 'SitesController@create']);
Route::get('/sites/{id}', ['as' => 'sites.home', 'uses' => 'SitesController@home']);

Route::get('/sites/{id}/add', ['as' => 'sites.emails.add', 'uses' => 'EmailController@add']);
Route::post('/sites/{id}/add', ['as' => 'sites.emails.create', 'uses' => 'EmailController@create']);
Route::get('/sites/{id}/send', ['as' => 'sites.emails.send', 'uses' => 'EmailController@send']);
Route::post('/sites/{id}/send', ['as' => 'sites.emails.mail', 'uses' => 'EmailController@mail']);
Route::get('/sites/{id}/emails/{tag?}', ['as' => 'sites.emails.directory', 'uses' => 'EmailController@emails']);

Route::get('/logs', ['as' => 'logs.index', 'uses' => 'LogController@index']);
Route::get('/logs/clear', ['as' => 'logs.clear', 'uses' => 'LogController@clear']);
