<?php

return array(

	/*
	|--------------------------------------------------------------------------
	| Third Party Services
	|--------------------------------------------------------------------------
	|
	| This file is for storing the credentials for third party services such
	| as Stripe, Mailgun, Mandrill, and others. This file provides a sane
	| default location for this type of information, allowing packages
	| to have a conventional place to find your various credentials.
	|
	*/

	'mailgun' => array(
		'domain' => '',
		'secret' => '',
	),

	'mandrill' => array(
		'secret' => '',
	),

	'stripe' => array(
		'model'  => 'User',
		'secret' => '',
	),

    'dropbox' => [
        'token'  => $_ENV['DROPBOX_TOKEN'],
        'app'    => $_ENV['DROPBOX_APP'],
    ],

    'transport' => [
        'app_id'  => $_ENV['TRANSPORT_APP_ID'],
        'api_key' => $_ENV['TRANSPORT_API_KEY'],
    ],

	'eventbrite' => [
		'client_secret' => $_ENV['EVENTBRITE_CLIENT_SECRET'],
		'api_key' => $_ENV['EVENTBRITE_API_SECRET'],
	]

);
