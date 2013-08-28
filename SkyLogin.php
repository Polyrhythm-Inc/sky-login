<?php

namespace SkyLogin;

//module dependencies
require_once(dirname(__FILE__) . "/vendors/SplClassLoader.php");
//auto loader
$classLoader = new \SplClassLoader(null, __DIR__);
$classLoader->register();


use lib\configure\Configure;

class SkyLogin {

  /*   properties   */

  private static $currentPlatformId = null;

  private static $activatedPlatformList = array();

  /*   methods   */

  private function __construct(){}

  public static function initialize($platformName = null){

    //Configure::parseJson('platforms', dirname(__FILE__) . '/resource/platform.json');

    if($platformName === null){ return; }

    $className = self::getPlatformClassName($platformName);
    self::$activatedPlatformList[$platformName] = new $className();
    self::$currentPlatformId = $platformName;

  }

  public static function __callStatic($name, $arguments = array()){
    return self::$activatedPlatformList[self::$currentPlatformId]->$name($arguments);
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
    $className = "\\lib\agent\\" . $platformName;
    return $className;
  }

}