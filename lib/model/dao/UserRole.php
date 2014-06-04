<?php

namespace SkyLogin\model;

use SkyLogin\exception\UnexpectedParameterException;
use SkyLogin\util\Validator;

class UserRole extends \SkyLogin\model\BaseDao {


  public static function getAll($userId){

    if( empty($userId) ){
      throw new UnexpectedParameterException;
    }

    return self::all(array('conditions' => array('user_id' => $userId)));
  }

  public static function getByUserIdAndRoleId($userId, $roleId){

    if( empty($userId) || empty($roleId) ){
      throw new UnexpectedParameterException;
    }

    return self::find_by_user_id_and_role_id($userId, $roleId);
  }

  public static function add($params = array()){

    Validator::required($params, 
      array(
        'user_id',
        'role_id',
      )
    );

    $now = date('Y-m-d H:i:s');
    $params['created'] = (isset($params['created'])) ? $params['created'] : $now;
    $params['modified'] = (isset($params['modified'])) ? $params['modified'] : $now;

    return self::create($params);
  }

  public static function delteByUserIdAndRoleId($userId, $roleId){

    if( empty($userId) || empty($roleId) ){
      throw new UnexpectedParameterException;
    }

    $userRole = self::getByUserIdAndRoleId($userId, $roleId);
    return $userRole->delete();
  } 

}