<?php

namespace lib\datastore\dao;

class User extends \ActiveRecord\Model { 

  public static function getByUserId(){

  }

  public static function getByEmailAndPasswd($email, $passwd){
    return self::find_by_email_and_password($email, $passwd);
  }

}
