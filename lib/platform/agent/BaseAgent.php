<?php

namespace SkyLogin\platform\agent;

use SkyLogin\model\User;
use SkyLogin\storage\Session;
use SkyLogin\model\UserRole;
use SkyLogin\model\Role;
use SkyLogin\Configure;

abstract class BaseAgent {

  protected $isAuthorized = false;

  protected $req;

  public function isAuthorized(){
    return $this->isAuthorized;
  }

  protected function decorateUserData(){

    $me = Session::get('me');

    if(Configure::get('enableContainUserRoleData')){

      //over write user info.
      $roles = \SkyLogin\Model\UserRole::getAll($me['id']);
      if(!is_null($roles))
      {
        $me['role'] = array();
        foreach($roles as $key => $val){
          $me['role'][] = $val->to_array();
        }
      }
    }else{
      $me['role'] = array();
    }

    Session::write('me', $me);
  }

  public function hasRole($key){
    $me = Session::get('me');

    foreach ($me['role'] as $key1 => $val) {
      $role = Role::getById($val['role_id']);
      if($val['role_id'] == $key || $role['name'] == $key){
        return true;
      }
    }
    return false;
  }

  public function inGroup(){

  }

}
