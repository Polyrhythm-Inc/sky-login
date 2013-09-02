<?php

namespace lib\model\dao;

use lib\exception\UnexpectedParameterException;
use lib\util\Validator;

class UserPlatformEachAuthentication extends \ActiveRecord\Model { 

  public static function getByPlatformIdAndAuthToken($pid, $token){
    
    if(empty($pid) || empty($token)){
      throw new UnexpectedParameterException;
    }

    return self::find_by_platform_id_and_auth_token($pid, $token);
  }

  public static function add($params = array(), $passwordHashChange = true){

    Validator::required($params, 
      array(
        'user_id',
        'platform_id',
        'platform_user_id',
        'auth_token',
        'expires',
      )
    );

    $now = date('Y-m-d H:i:s');

    $params['created'] = $now;
    $params['modified'] = $now;

    return self::create($params);
  }

  public static function updateTokenAndExpires(){
    
  }

}
