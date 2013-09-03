<?php

namespace lib\model\dao;

use lib\exception\UnexpectedParameterException;
use lib\util\Validator;

class User extends \lib\model\dao\BaseDao {

  public static function getByUserId($id){
    
    if(empty($id)){
      throw new UnexpectedParameterException;
    }
    return self::first($id);
    
  }

  public static function getByUserIdRelationSequenceId($id){

    if(empty($id)){
      throw new UnexpectedParameterException;
    }
    return self::find_by_user_id_and_sequence_id($id);
  }

  public static function add($params = array(), $passwordHashChange = true){

    Validator::required($params, 
      array(
        'name',
        'user_id_relation_sequence_id',
        'email',
        'password',
        'role_id'
      )
    );

    $now = date('Y-m-d H:i:s');
    $params['created'] = $now;
    $params['modified'] = $now;
    return self::create($params);
  }


  public static function getByNameAndEmailAndPasswd($name, $email, $passwd){

    if(empty($name) || empty($email) || empty($passwd)){
      throw new UnexpectedParameterException;
    }

    return self::find_by_name_and_email_and_password($name, $email, $passwd);
  }


  public static function getByEmailAndPasswd($email, $passwd){

    if(empty($email) || empty($passwd)){
      throw new UnexpectedParameterException;
    }

    return self::find_by_email_and_password($email, $passwd);
  }

  public static function getByNameAndPasswd($name, $passwd){

    if(empty($name) || empty($passwd)){
      throw new UnexpectedParameterException;
    }

    return self::find_by_name_and_password($name, $passwd);
  }

}
