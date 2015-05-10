<?php

return [

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

	'mailgun' => [
		'domain' => '',
		'secret' => '',
	],

	'mandrill' => [
		'secret' => '',
	],

	'ses' => [
		'key' => '',
		'secret' => '',
		'region' => 'us-east-1',
	],

	'stripe' => [
		'model'  => 'App\User',
		'secret' => '',
	],

	'facebook' => [
	  'client_id' => '932156280156672',
      'client_secret' => '8f4a9d5e2dc5b6471baf1076d8ecf5da',
      'redirect' => url('/account/facebook'),
	],

	'google' => [
	  'client_id' => '284235294294-7iqavhd74kblladsojov09v1rh89lf4t.apps.googleusercontent.com',
      'client_secret' => 'lKAT5dybOXXQZSqKgVlDC5tA',
      'redirect' => url('/account/google'),
	]

];
