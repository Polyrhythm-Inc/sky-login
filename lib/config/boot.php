<?php

use SkyLogin\Datastore;

$conf = Datastore::get(Datastore::$currentUsing);

\ActiveRecord\Config::initialize(function($cfg) use ($conf)
{
   $cfg->set_model_directory(SKYLOGIN_LIB_PATH . '/model/dao');
   $cfg->set_connections(array(
       'development' => "mysql://{$conf['user']}:{$conf['passwd']}@{$conf['host']}/{$conf['db']}"));
});