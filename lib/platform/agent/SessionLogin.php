<?php

namespace lib\platform\agent;

use lib\platform\provider\AgentProvider;
use lib\platform\agent\BaseAgent;
use lib\exception\UnexpectedParameterException;
use lib\storage\Session;
use lib\model\dao\User;
use lib\util\Utility;
use lib\configure\Configure;
use lib\model\service\UserService;
use lib\http\Request;
use lib\Consts;

Session::start();

class SessionLogin extends BaseAgent implements AgentProvider {

  private $platformId = 1;

  public function __construct(){}


  public function register($params = array()){

    $exsits = User::getByNameAndEmailAndPasswd($params['user_name'], $params['email'], $params['password']);

    if(is_null($exsits)){

      $params = array(
        'user_name' => $params['user_name'],
        'email' => $params['email'],
        'password' => $params['password'],
        'role' => $params['role'],
        'hash_id' => $params['hash_id'],
        'platform_id' => $this->platformId
      );

      UserService::register($params);

      return Consts::REGISTER_USER_SUCCESS;

    }else{

      return Consts::REGISTER_USER_ALREADY_EXSITS;

    }
  }

  public function login($params = array()){

    $isEmaiLogin = Utility::isValidEmailFormat($params['login']);

    $exsits = false;

    if($isEmaiLogin){
      $exists = User::getByEmailAndPasswd($params['login'], $params['password']);
    }else{
      $exists = User::getByNameAndPasswd($params['login'], $params['password']);
    } 

    if(!is_null($exists)){
      Session::write('isLogin', true);
      Session::write('me', $exists->to_array());

      return Consts::USER_LOGIN_SUCCEEDED;

    }
    else
    {
      return Consts::USER_LOGIN_FAILED;
    }
  }

  public function auth($callback = null){

    if(Session::has('isLogin') && Session::has('me') && Session::get('isLogin')){
      $this->isAuthorized = true;
      
      if(!is_null($callback)){
        $callback(Session::get('me'));
      }
    }
  }

  public function logout(){
    Session::destroy();
  }

}




