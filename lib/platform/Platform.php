<?php

namespace lib\platform;

class Platform {

  /*   properties   */
  private static $currentPlatformId = null;

  private static $activatedPlatformList = array();

  /*   methods   */
  private function __construct(){}

  public static function initialize($platformName = null){
    
    __boot_loader();
    
    if($platformName === null){ return; }

    $className = self::getPlatformClassName($platformName);
    self::$activatedPlatformList[$platformName] = new $className();
    self::$currentPlatformId = $platformName;

  }

  public static function __callStatic($name, $arguments = array()){
    return call_user_func_array(array(self::$activatedPlatformList[self::$currentPlatformId], $name), $arguments);
  }

  public static function getInstance($platformName){
    $className = self::getPlatformClassName($platformName);
    return new $className();
  }

  public static function getInstanceAsStatic($platformName){
    if(isset(self::$activatedPlatformList[$platformName])){
      return self::$activatedPlatformList[$platformName];
    }
    else
    {
      $className = self::getPlatformClassName($platformName);
      self::$activatedPlatformList[$platformName] = new $className();
    }
  }

  private static function getPlatformClassName($platformName){
    $className = "\\lib\\platform\\agent\\" . $platformName;
    return $className;
  }

}