<?php

//module dependencies
require_once dirname(__FILE__)    . '/../common.php';
require_once SKYLOGIN_VENDOR_PATH . '/php-activerecord/ActiveRecord.php';
require_once SKYLOGIN_VENDOR_PATH . '/SplClassLoader.php';

//auto loader
$classLoader = new \SplClassLoader(null, SKYLOGIN_ROOT);
$classLoader->register();

\SkyLogin\lib\configure\Datastore::add('default', array(
    'host' => 'localhost',
    'port' => null,
    'user' => 'root',
    'passwd' => 'y_takei',
    'db' => 'skylogin_test',
  )
);

$conf = \SkyLogin\lib\configure\Datastore::get('default');

\ActiveRecord\Config::initialize(function($cfg) use ($conf)
{
   //$cfg->set_model_directory(dirname(__FILE__) . '/model/dao');
   $cfg->set_connections(array(
       'development' => "mysql://{$conf['user']}:{$conf['passwd']}@{$conf['host']}/{$conf['db']}"));
});