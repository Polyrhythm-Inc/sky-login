<?php

namespace SkyLogin;

class Request   extends  \SkyLogin\lib\http\Request {}
class Platform  extends  \SkyLogin\lib\platform\Platform {}
class Datastore extends  \SkyLogin\lib\configure\Datastore {}
class Configure extends  \SkyLogin\lib\configure\Configure {}


use SkyLogin\lib\model\dao\UserRole;

class Role {

  public static function add($userId, $roleId){
    return UserRole::add(array(
      'user_id' => $userId,
      'role_id' => $roleId
    ));
  }

  public static function remove($userId, $roleId){
    return UserRole::delteByUserIdAndRoleId($userId, $roleId);
  }

}

use SkyLogin\lib\model\dao\UserDevice;

class Device {

  public static function add(){

  }

}