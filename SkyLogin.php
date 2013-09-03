<?php

namespace SkyLogin;

//module dependencies
require_once dirname(__FILE__) . '/vendors/php-activerecord/ActiveRecord.php';
require_once dirname(__FILE__) . "/vendors/SplClassLoader.php";

//auto loader
$classLoader = new \SplClassLoader(null, __DIR__);
$classLoader->register();

use lib\configure\Configure;
use lib\configure\Datastore;

class Platform {

  /*   properties   */
  private static $currentPlatformId = null;

  private static $activatedPlatformList = array();

  /*   methods   */
  private function __construct(){}

  public static function initialize($platformName = null){

    require_once dirname(__FILE__) . '/lib/boot.php';

    //Configure::parseJson('platforms', dirname(__FILE__) . '/resource/platform.json');

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
    $className = "\\lib\\agent\\" . $platformName;
    return $className;
  }

}

class Connection {
  public static function __callStatic($name, $arguments = array()){
    $class = "\\lib\\configure\\Datastore";
    return call_user_func_array(array($class, $name), $arguments);
  }
}

class Config {
  public static function __callStatic($name, $arguments = array()){
    $class = "\\lib\configure\\Configure";
    return call_user_func_array(array($class, $name), $arguments);
  }
}
