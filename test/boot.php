<?php

//module dependencies
require_once dirname(__FILE__) . '/../vendors/php-activerecord/ActiveRecord.php';
require_once dirname(__FILE__) . '/../lib/configure/Datastore.php';
require_once dirname(__FILE__) . '/../lib/exception/UnexpectedParameterException.php';
require_once dirname(__FILE__) . '/../lib/util/Utility.php';

use lib\configure\Datastore;

define('LIB_PATH', dirname(__FILE__) . '/../lib');
define('FIXTURES_PATH', dirname(__FILE__) . '/fixtures');

Datastore::add('default', array(
    'host' => 'localhost',
    'port' => null,
    'user' => 'root',
    'passwd' => 'y_takei',
    'db' => 'skylogin_test',
  )
);

$conf = Datastore::get('default');

\ActiveRecord\Config::initialize(function($cfg) use ($conf)
{
   //$cfg->set_model_directory(dirname(__FILE__) . '/model/dao');
   $cfg->set_connections(array(
       'development' => "mysql://{$conf['user']}:{$conf['passwd']}@{$conf['host']}/{$conf['db']}"));
});


function parseJson($path){
  return (array)json_decode(file_get_contents($path));
}