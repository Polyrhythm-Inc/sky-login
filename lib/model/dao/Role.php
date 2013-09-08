<?php

namespace SkyLogin\lib\model\dao;

use SkyLogin\lib\exception\UnexpectedParameterException;
use SkyLogin\lib\util\Validator;
use SkyLogin\lib\util\Parser;

class Role { 

  private static $roles = null;


  public static function getById($id){

    if(is_null(self::$roles)){
      self::$roles = \SkyLogin\lib\util\Parser::json(SKYLOGIN_MASTER_PATH . '/role.json');
    }
    
    if(empty($id)){
      throw new UnexpectedParameterException;
    }
    return (array)self::$roles->$id;
  }
}
