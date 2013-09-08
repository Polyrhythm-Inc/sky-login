<?php

namespace SkyLogin\lib\storage;

class Session {

  public static $prefix = 'SkyLogin::';

  private function __construct(){}

  public static function start(){
    if (!session_id()) {
      session_start();
    }
  }

  public static function has($key){
    if(isset($_SESSION[self::$prefix.$key])){
      return true;
    }
    return false;
  }

  public static function write($key, $val){
    $_SESSION[self::$prefix.$key] = $val;
  }

  public static function get($key){
    if(isset($_SESSION[self::$prefix.$key])){
      return $_SESSION[self::$prefix.$key];
    }
    return null;
  }

  public static function del($key){
    unset($_SESSION[self::$prefix.$key]);
  }

  public static function destroy(){
    $_SESSION = array();
    session_destroy();
  }

}