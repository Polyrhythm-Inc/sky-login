<?php

namespace lib\datastore\client;

require_once (dirname(__FILE__) . '/../../../vendors/php-activerecord/ActiveRecord.php';

use lib\configure\Datastore;


class MysqlClient {

  private $db = null;

  public function createConnection($connectionName){

    Datastore::get($connectionName);
    //var_dump(Datastore::getMap());
    //$this->db = new mysqli("localhost", "ID", "PASSWORD", "db_webprogrammer");

    ActiveRecord\Config::initialize(function($cfg)
    {
       $cfg->set_model_directory('dao');
       $cfg->set_connections(array(
           'development' => 'mysql://username:password@localhost/database_name'));
    });



  }

}