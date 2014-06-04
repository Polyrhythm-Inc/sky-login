<?php

namespace SkyLogin\model;

use SkyLogin\model\User;
use SkyLogin\model\UserIdRelation;
use SkyLogin\model\UserEachPlatformAuthentication;
use SkyLogin\util\Utility;
use SkyLogin\util\Validator;
use SkyLogin\Configure;

class UserService {

  public static function register($params = array(), $addTransactions = array()){

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


      $user_id_relation_sequence_id = null;
      if(Configure::get('enableUserhashId')){
        $res = UserIdRelation::add($hashId);

        if(empty($res)){
          throw new Exception('User registration was failed.');
        }

        $user_id_relation_sequence_id = $res['id'];
      }

      $data = array(
        'user_id_relation_sequence_id' => $user_id_relation_sequence_id,
        'name' => $userName,
        'display_name' => isset($params['display_name']) ? $params['display_name'] : $userName,
        'email' => $email,
        'password' => sha1( $password . \SkyLogin\Configure::get('securitySalt') )
      );

      if(isset($params['custom_attributes'])){
          foreach($params['custom_attributes'] as $key => $val){
            $data[$key] = $val;
          }
      }

      $user = User::add($data);
      if(empty($user)){
        throw new Exception('User registration was failed.');
      }

      $data = array(
        'user_id' => $user->id,
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

      $res = UserEachPlatformAuthentication::add($data);
      if(empty($res)){
        throw new Exception('User registration was failed.');
      }

      foreach($addTransactions as $val){
        $val($user->to_array());
      }

      $c->commit();

      return User::first($user->id);

    }catch(\Exception $e){

      $c->rollback();

      throw $e;
    }

  }
}
