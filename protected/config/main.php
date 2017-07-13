<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'rubuy',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.components.widget.*',
		'application.fundaction.*',
		'ext.helper.*',
		'application.proxy.*',
		'application.vendor.youzan-sdk.lib.*',
		'ext.redis.*',
	),

	'defaultController'=>'login',

	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			 'class' => 'WebUser',
			//'class' => 'WebUser',
			// enable cookie-based authentication
			'loginUrl' => array('login/index'),
			'loginRequiredAjaxResponse' => '{"code": 401, "msg": "please login"}',
			'allowAutoLogin'=>true,
		),
		/*'db'=>array(
			'connectionString' => 'sqlite:protected/data/blog.db',
			'tablePrefix' => 'tbl_',
		),*/
		// uncomment the following to use a MySQL database


		'db'=>array(
			'connectionString' => 'mysql:host=106.14.69.154;dbname=rubuy',
			'emulatePrepare' => true,
			'username' => 'ruby',
			'password' => 'YanDingWeb2016',
			'charset' => 'utf8',
		),
		'session' => array(
			'class' => 'system.web.CDbHttpSession',
			'connectionID' => 'db',
			'sessionTableName' => 'admin_session',
			'timeout' => 86400,
		),
		
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(
				'post/<id:\d+>/<title:.*?>'=>'post/view',
				'posts/<tag:.*?>'=>'post/index',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
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
	'params'=>require(dirname(__FILE__).'/params.php'),


);