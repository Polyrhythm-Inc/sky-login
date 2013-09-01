<?php

namespace lib\model\dao;

use \lib\model\client\MysqlClient;

class BaseDao {

  public function __construct(){
    $db = new MysqlClient();


    $db::createConnection('default');

  }

}