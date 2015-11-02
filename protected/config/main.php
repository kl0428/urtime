<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'urtime',
	'language' =>'zh_cn',
	'charset' => 'utf-8',
	'defaultController' =>'index',
	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.services.v0.*',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool

		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'123456',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
	),

	// application components
	'components'=>array(

		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),

		// uncomment the following to enable URLs in path-format

		'urlManager'=>array(
			'urlFormat'=>'path',
			'showScriptName' =>false,
			'urlSuffix' =>'.html',
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),


		// database settings are configured in database.php
		'db'=>require(dirname(__FILE__).'/database.php'),

		/*'cache'=>array(
			'class'=>'ext.redis.CRedisCache',
			//'keyPrefix' => false,
			//'hashKey'   => false,
			//'serializer'=>false,
			'servers'   => array(
				array(
					'host' => '127.0.0.1',
					'port' => 6379,
					'password' => '123456',
				),
			),
		),*/
		'cache_local' => array(
			'class' => 'ext.redis.CRedisCache',
			'keyPrefix'=>false,
			'hashKey'=>false,
			//'serializer'=>false,
			'servers' => array(
				array(
					'host' => '127.0.0.1',
					'port' => 6379,
					'password' => '123456',
				),
			),
		),

		'cache_ext' =>array(
			'class' => 'ext.redis.CgtzRedisCache',
			'keyPrefix'=>false,
			'hashKey'=>false,
			'serializer'=>false,
			'hostname' => '127.0.0.1',
			'port' => 6379,
			'password' => '123456',
			'database'=>2,
		),

		//read-only redis cache
		'cache2' => array(
			'class' => 'ext.redis.CRedisCache',
			'keyPrefix'=>'',
			'hashKey'=>false,
			'serializer'=>false,
			'servers' => array(
				array(
					'host' => '192.168.10.106',
					'port' => 6379,
					'password' => '00000000',

				),
			),
		),

		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),

		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),

	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'webmaster@example.com',
		'app'	=>array(
			'MobileApiKey'=>'1234567',
			'MobileApiValidtime'=>10*60,
		),
	),
);
