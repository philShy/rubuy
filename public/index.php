<?php
date_default_timezone_set("Asia/Shanghai");
ini_set("display_errors", "on");
// error_reporting(E_ERROR | E_WARNING | E_PARSE);
error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE);

// change the following paths if necessary
$yii=dirname(__FILE__).'/../protected/library/framework/yii.php';
$config=dirname(__FILE__).'/../protected/config/main.php';

// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',true);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

defined('YII_ENV') or define('YII_ENV', 'development');

require_once($yii);
Yii::createWebApplication($config)->run();
