<?php

namespace lib\datastore\dao;

use \lib\datastore\client\MysqlClient;

class BaseDao {

  public function __construct(){
    $db = new MysqlClient();


    $db::createConnection('default');

  }

}