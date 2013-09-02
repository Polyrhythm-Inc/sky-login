<?php

namespace lib\model\service;

use lib\model\dao\User;
use lib\model\dao\UserIdRelation;
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
        'hash_id'
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

      $params = array(
        'user_id_relation_sequence_id' => $res->id,
        'name' => $userName,
        'display_name' => $userName,
        'email' => $email,
        'password' => $password,
        'role_id' => $roleId
      );
      

      $res = User::add($params);
      if(empty($res)){
        throw new Exception('User registration was failed.');
      }

      $c->commit();

      return true;

    }catch(Exception $e){
      $c1->rollback();
      $c2->rollback();

      return false;
    }

  }

}