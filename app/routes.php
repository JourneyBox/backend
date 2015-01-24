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

Route::group(array('prefix' => 'eventbrite'), function()
{
	Route::get('storeAccessToken/{id}/{access_token}', 'EventbriteController@storeAccessToken');
	Route::get('getUpcomingEvents/{id}', 'EventbriteController@getUpcomingEvents');
	Route::get('getLondonEvents/{id}', 'EventbriteController@getLondonEvents');
});