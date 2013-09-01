<?php

namespace lib\model\dao;

use lib\exception\UnexpectedParameterException;

class UserIdRelation extends \ActiveRecord\Model { 

  public static function add($hashId){

    if(empty($hashId)){
      return new UnexpectedParameterException;
    }

    $now = date('Y-m-d h:i:s');

    $params = array(
      'hash_id' => $hashId,
      'created' => $now,
      'modified' => $now
    );
    return self::create($params);
  }

  public static function getByHadhId($hashId){
    return self::find_by_hash_id($hashId);
  }

}