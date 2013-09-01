<?php

use lib\configure\Datastore;

$conf = Datastore::get('default');

\ActiveRecord\Config::initialize(function($cfg) use ($conf)
{
   $cfg->set_model_directory(dirname(__FILE__) . '/model/dao');
   $cfg->set_connections(array(
       'development' => "mysql://{$conf['user']}:{$conf['passwd']}@{$conf['host']}/{$conf['db']}"));
});