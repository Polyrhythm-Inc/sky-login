<?php

namespace lib\model\dao;

use lib\exception\UnexpectedParameterException;
use lib\util\Validator;
use lib\util\Parser;

class Role extends \lib\model\dao\BaseDao { 

  private static $roles = null;


  public static function getById($id){

    if(is_null(self::$roles)){
      self::$roles = \lib\util\Parser::json(SKYLOGIN_MASTER_PATH . '/role.json');
    }
    
    if(empty($id)){
      throw new UnexpectedParameterException;
    }
    return self::$roles->$id;
  }
}
