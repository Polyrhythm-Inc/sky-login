<?php

class Session {

  private function __construct(){}

  public static function start(){
    if (!session_id()) {
      session_start();
    }
  }

  public static function write($key, $val){
    $_SESSION[$key] = $val;
  }

  public static function get($key){
    if(isset($_SESSION[$key])){
      return $_SESSION[$key];
    }
    return null;
  }

  public static function del($key){
    unset($_SESSION[$key]);
  }

  public static function destroy(){
    $_SESSION = array();
    session_destroy();
  }

}