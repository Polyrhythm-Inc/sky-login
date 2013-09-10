<?php

namespace SkyLogin\lib\model\dao;

use SkyLogin\lib\exception\UnexpectedParameterException;
use SkyLogin\lib\util\Validator;
use SkyLogin\lib\util\Parser;

class Role { 

  private static $roles = null;

  private static $jsonPath = null;

  private function __construct(){}

  public static function setJsonPath($path){
    self::$jsonPath = $path;
  }

  public static function getById($id){

    if(is_null(self::$roles)){
      self::$roles = \SkyLogin\lib\util\Parser::json( is_null(self::$jsonPath) ? SKYLOGIN_MASTER_PATH . '/role.json' : $jsonPath); 
    }
    
    if(empty($id)){
      throw new UnexpectedParameterException;
    }
    return (array)self::$roles->$id;
  }
}
