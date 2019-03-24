<?php

return [

	/* Important Settings */

	// ======================================================================
	// never remove 'web', just put your middleware like auth or admin (if you have) here. eg: ['web','auth']
	'middlewares' => ['web'],
	// you can change default route from sms-admin to anything you want
	'route' => 'sms-admin',
	// SMS.ir Web Service URL
	'webservice-url' => 'https://ws.sms.ir/',
	// SMS.ir Api Key
	'api-key' => env('SMSIR_API_KEY'),
	// SMS.ir Secret Key
	'secret-key' => env('SMSIR_SECRET_KEY'),
	// Your sms.ir line number
	'line-number' => env('SMSIR_LINE_NUMBER','Your Sms.ir Line Number'),
	// ======================================================================
	// set true if you want log to the database
	'db-log' => false,
	// if you don't want to include admin panel routes set this to false
	'panel-routes' => true,
	/* Admin Panel Title */
	'title' => 'مدیریت پیامک ها',
	// How many log you want to show in sms-admin panel ?
	'in-page' => '15'
];
