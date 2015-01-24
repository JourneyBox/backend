<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::group(array('prefix' => 'dropbox'), function()
{
	Route::get('requestToken', 'DropboxController@requestToken'); // ?code=
});

Route::group(array('prefix' => 'eventbrite'), function()
{
	Route::get('requestToken', 'EventbriteController@requestToken'); // ?code=
	Route::get('assignToken', 'EventbriteController@assignToken'); // ?id=&access_token=
	Route::get('getUpcomingEvents', 'EventbriteController@getUpcomingEvents'); // ?id=
	Route::get('getLondonEvents', 'EventbriteController@getLondonEvents'); // ?id=
});

Route::group(array('prefix' => 'travel'), function()
{
	Route::get('/', 'TransportController@requestToken');
});

Route::group(array('prefix' => 'oauth'), function()
{
    Route::get('/dropbox', 'OAuthController@dropbox');
    //Route::get('/eventbrite', 'OAuthController@eventbrite');
});


Route::get('/dashboard', 'DashboardController@index');
Route::get('/', 'HomeController@index');
