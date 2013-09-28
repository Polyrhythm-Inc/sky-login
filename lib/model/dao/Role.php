<?php

namespace SkyLogin\lib\model\dao;

use SkyLogin\lib\exception\UnexpectedParameterException;
use SkyLogin\lib\util\Validator;
use SkyLogin\lib\util\Parser;

class Role { 

  private static $roles = null;

  private static $jsonPath = null;

  private function __construct(){}

  public static function setJsonPath($path = 'default'){
    if($path != 'default'){
      self::$jsonPath = $path;
    }else{
      self::$jsonPath = SKYLOGIN_MASTER_PATH . '/role.json';
    }
    self::$roles = \SkyLogin\lib\util\Parser::json(self::$jsonPath); 
  }

  public static function getMap(){
    return (array)self::$roles;
  }

  public static function getById($id){

    if(empty($id)){
      throw new UnexpectedParameterException;
    }
    return (array)self::$roles->$id;
  }
}
