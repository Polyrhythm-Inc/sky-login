<?php

namespace lib\configure;

class BaseConfigure {

  public static function parseJson($key, $path){
    $s = file_get_contents($path);
    $j = json_decode($s);
    self::$configMap[$key] = $j;
  }

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