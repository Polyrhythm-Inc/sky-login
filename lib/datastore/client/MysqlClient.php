<?php

namespace lib\datastore\client;

use lib\configure\Datastore;

class MysqlClient {

  private $db = null;

  public function createConnection($connectionName){

    Datastore::get($connectionName);

    //$this->db = new mysqli("localhost", "ID", "PASSWORD", "db_webprogrammer");
  }

}