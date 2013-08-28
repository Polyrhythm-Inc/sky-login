<?php

namespace lib\configure;

class Configure {

  private static $configMap = array();

  public static function parseJson($key, $path){
    $s = file_get_contents($path);
    $j = json_decode($s);
    self::$configMap[$key] = $j;
  }

  public static function write($key, $vale){
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