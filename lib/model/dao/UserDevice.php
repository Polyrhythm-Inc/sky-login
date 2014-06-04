<?php

namespace SkyLogin\model;

use SkyLogin\exception\UnexpectedParameterException;
use SkyLogin\util\Validator;

class UserDevice extends \SkyLogin\model\BaseDao { 

  public static function getByUserId($userId){
    if(empty($userId)){
      throw new UnexpectedParameterException;
    }
    return self::all(array('conditions' => array('user_id' => $userId)));
  }


  public static function getByOsTypeIdAndDeviceId($osTypeId, $deviceId){

    if(empty($osTypeId) || empty($deviceId)){
      throw new UnexpectedParameterException;
    }

    $osTypeId = self::connection()->escape($osTypeId);
    $deviceId = self::connection()->escape($deviceId);

    $table = self::table();
    $sql = "SELECT id, user_id, device_id, os_type_id FROM {$table->table} ";
    $castValue = 'CAST(x' . $deviceId . " as UNSIGNED)";
    $sql .= "WHERE os_type_id = {$osTypeId} AND device_id_dec = " . $castValue;

    try {
    
      $stmt = self::connection()->connection->query($sql);

      if(!$stmt){
        throw new \ActiveRecord\DatabaseException($this);  
      }

      return $stmt->fetch(\PDO::FETCH_ASSOC);

    } catch (\PDOException $e) {
      throw new \ActiveRecord\DatabaseException($e);
    }

  }


  public static function add($params){

    Validator::required($params, 
      array(
        'user_id',
        'device_id',
        'device_token',
        'os_type_id'
      )
    );

    $now = date('Y-m-d h:i:s');

    foreach($params as $key => $val){
      $params[$key] = self::connection()->escape($val);
    }


    $table = self::table();
    $sql = 'INSERT INTO '.$table->table.' ';
    $sql .= '(user_id, device_id, device_id_dec, device_token, os_type_id, created, modified) ';
    $sql .= 'VALUES ';
    $castValue = 'CAST(x' . $params['device_id'] . " as UNSIGNED)";
    $sql .= "({$params['user_id']}, {$params['device_id']}, $castValue, {$params['device_token']}, {$params['os_type_id']}, '{$now}', '{$now}')";

    try {
      
      if(!self::connection()->connection->query($sql)){
        throw new \ActiveRecord\DatabaseException($this);  
      }

      return array(
        'id' => self::connection()->connection->lastInsertId()
      );

    } catch (\PDOException $e) {
      throw new \ActiveRecord\DatabaseException($e);
    }
    
  }  

}