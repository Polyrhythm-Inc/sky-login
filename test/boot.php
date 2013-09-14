<?php

date_default_timezone_set('Asia/Tokyo');

//module dependencies
require_once dirname(__FILE__)    . '/../common.php';
require_once SKYLOGIN_VENDOR_PATH . '/php-activerecord/ActiveRecord.php';
require_once SKYLOGIN_VENDOR_PATH . '/SplClassLoader.php';

//auto loader
$classLoader = new \SplClassLoader(null, SKYLOGIN_ROOT);
$classLoader->register();


if(!isset($_SERVER['SKY_LOGIN_DB_CONFIG_FILE_PATH'])){
  echo "Environment variable SKY_LOGIN_DB_CONFIG_FILE_PATH must required.";
  exit(1);
}

require_once $_SERVER['SKY_LOGIN_DB_CONFIG_FILE_PATH'];

$env = isset($_SERVER['PHP_ENV']) ? $_SERVER['PHP_ENV'] : 'development';

$conf = \SkyLogin\lib\configure\Datastore::get($env);

\ActiveRecord\Config::initialize(function($cfg) use ($conf)
{
   //$cfg->set_model_directory(dirname(__FILE__) . '/model/dao');
   $cfg->set_connections(array(
       'development' => "mysql://{$conf['user']}:{$conf['passwd']}@{$conf['host']}/{$conf['db']}"));
});