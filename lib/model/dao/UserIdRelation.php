<?php

namespace lib\model\dao;

use lib\exception\UnexpectedParameterException;

class UserIdRelation extends \ActiveRecord\Model { 

  public static function add($hashId){

    if(empty($hashId)){
      throw new UnexpectedParameterException;
    }

    $now = date('Y-m-d h:i:s');
    $hashId = self::connection()->escape($hashId);

    $table = self::table();
    $sql = 'INSERT INTO '.$table->table.' ';
    $sql .= '(hash_id, hash_id_dec, created, modified) ';
    $sql .= 'VALUES ';
    $castValue = 'CAST(x' . $hashId . " as SIGNED)";
    $sql .= "({$hashId}, $castValue, '{$now}', '{$now}')";

    try {
      
      if(!self::connection()->connection->query($sql)){
        throw new \ActiveRecord\DatabaseException($this);  
      }

      return true;

    } catch (\PDOException $e) {
      throw new \ActiveRecord\DatabaseException($e);
    }
    
  }

  public static function getByHashId($hashId){

    if(empty($hashId)){
      throw new UnexpectedParameterException;
    }

    $hashId = self::connection()->escape($hashId);

    $sql = "SELECT id, hash_id, hash_id_dec FROM user_id_relations ";
    $castValue = 'CAST(x' . $hashId . " as SIGNED)";
    $sql .= "WHERE hash_id_dec = " . $castValue;

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

}