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
	Route::get('requestToken', 'EventbriteController@requestToken'); // ?id=
	Route::get('assignToken', 'EventbriteController@assignToken'); // ?id=&access_token=
	Route::get('getUpcomingEvents', 'EventbriteController@getUpcomingEvents'); // ?id=
	Route::get('getLondonEvents', 'EventbriteController@getLondonEvents'); // ?id=
});