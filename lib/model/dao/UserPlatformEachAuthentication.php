<?php

namespace lib\model\dao;

use lib\exception\UnexpectedParameterException;
use lib\util\Validator;

class UserPlatformEachAuthentication extends \lib\model\dao\BaseDao { 

  public static function getByPlatformIdAndAuthToken($pid, $token){
    
    if(empty($pid) || empty($token)){
      throw new UnexpectedParameterException;
    }

    return self::find_by_platform_id_and_auth_token($pid, $token);
  }

  public static function add($params = array()){

    Validator::required($params, 
      array(
        'user_id',
        'platform_id',
      )
    );

    $now = date('Y-m-d H:i:s');

    $params['created'] = (isset($params['created'])) ? $params['created'] : $now;
    $params['modified'] = (isset($params['modified'])) ? $params['modified'] : $now;

    return self::create($params);
  }

  public static function updateByPlatformIdAndUserId($params = array(), $platform_id, $user_id){

    if(empty($params) || empty($platform_id) || empty($user_id)){
      throw new UnexpectedParameterException;
    }

    $upea = self::find_by_platform_id_and_user_id($platform_id, $user_id);
    foreach($params as $key => $val){
      $upea->$key = $val;
    }
    return $upea->save();

  }

}
