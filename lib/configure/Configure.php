<?php

namespace SkyLogin\lib\configure;

class Configure {
  
  protected static $configMap = array();

  public static function write($key, $value){
    self::$configMap[$key] = $value;
  }

  public static function get($key){
    if(isset(self::$configMap[$key])){
      return self::$configMap[$key];
    }
    return null;
  }

  public static function getMap(){
    return self::$configMap;
  }


}