<?php

namespace SkyLogin\lib\configure;

class Datastore {
  
  protected static $configMap = array();

  public static $currentUsing = null;

  public static function add($key, $value){
    self::$configMap[$key] = $value;
  }

  public static function get($key){
    if(isset(self::$configMap[$key])){
      return self::$configMap[$key];
    }
    return null;
  }

  public static function switchStore($env){
    self::$currentUsing = $env;
  }

  public static function getMap(){
    return self::$configMap;
  }
}