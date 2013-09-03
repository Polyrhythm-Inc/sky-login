<?php

namespace lib\model\service;

use lib\model\dao\User;
use lib\model\dao\UserIdRelation;
use lib\model\dao\UserPlatformEachAuthentication;
use lib\util\Utility;
use lib\util\Validator;

class UserService {

  public static function register($params){

    Validator::required($params, 
      array(
        'user_name',
        'email',
        'password',
        'role',
        'hash_id',
        'platform_id'
        )
    );

    $userName = $params['user_name'];
    $email = $params['email'];
    $password = $params['password'];
    $roleId = $params['role'];
    $hashId = $params['hash_id'];

    try{
      
      $c = User::connection();

      $c->transaction();

      $res = UserIdRelation::add($hashId);

      if(empty($res)){
        throw new Exception('User registration was failed.');
      }

      $data = array(
        'user_id_relation_sequence_id' => $res['id'],
        'name' => $userName,
        'display_name' => $userName,
        'email' => $email,
        'password' => $password,
        'role_id' => $roleId
      );

      $res = User::add($data);
      if(empty($res)){
        throw new Exception('User registration was failed.');
      }

      $data = array(
        'user_id' => $res->id,
        'platform_id' => $params['platform_id'],
      );
        
      if(isset($params['platform_user_id'])){
        $data['platform_user_id'] = $params['platform_user_id'];
      }

      if(isset($params['auth_token'])){
        $data['auth_token'] = $params['auth_token']; 
      }

      if(isset($params['expires'])){
        $data['expires'] = $params['expires'];
      }

      $res = UserPlatformEachAuthentication::add($data);
      if(empty($res)){
        throw new Exception('User registration was failed.');
      }

      $c->commit();

      return User::first($res->id);

    }catch(\Exception $e){
      throw $e;
      $c->rollback();
    }

  }

}