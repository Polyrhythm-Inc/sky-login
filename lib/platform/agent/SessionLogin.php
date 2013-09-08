<?php

namespace SkyLogin\lib\platform\agent;

use SkyLogin\lib\platform\provider\AgentProvider;
use SkyLogin\lib\platform\agent\BaseAgent;
use SkyLogin\lib\exception\UnexpectedParameterException;
use SkyLogin\lib\storage\Session;
use SkyLogin\lib\model\dao\User;
use SkyLogin\lib\util\Utility;
use SkyLogin\lib\configure\Configure;
use SkyLogin\lib\model\service\UserService;
use SkyLogin\lib\http\Request;

Session::start();

class SessionLogin extends BaseAgent implements AgentProvider {

  private $platformId = 1;

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

      try{

        $user = UserService::register($params);

      }catch(\Exception $e){
        if(preg_match('/Duplicate entry/', $e->__toString())){
          return new \SkyLogin\lib\platform\Status(
            array(
              'status' => false,
              'message' => 'DUPLICATE_ENTRY',
            )
          );
        }
        throw $e;
      }

      return new \SkyLogin\lib\platform\Status(
        array(
          'status' => true,
          'message' => 'USER_REGISTRATION_SUCCEEDED'
        )
      );

    }else{

      return new \SkyLogin\lib\platform\Status(
        array(
          'status' => false,
          'message' => 'REGISTER_USER_ALREADY_EXSITS'
        )
      );

    }
  }

  public function login($params = array()){

    $exsits = false;

    $enableEmailAuth = Configure::get('enableEmailAuth');
    $enableNameAuth = Configure::get('enableNameAuth');

    if($enableEmailAuth && $enableNameAuth){

      $isEmaiLogin = Utility::isValidEmailFormat($params['login']);
      if($isEmaiLogin){
        $exists = User::getByEmailAndPasswd($params['login'], $params['password']);
      }else{
        $exists = User::getByNameAndPasswd($params['login'], $params['password']);
      }

    }
    else if (!$enableEmailAuth && $enableNameAuth){
      $exists = User::getByNameAndPasswd($params['login'], $params['password']);
    }
    else
    {
      //default
      $exists = User::getByEmailAndPasswd($params['login'], $params['password']);
    }

    if(!is_null($exists)){
      Session::write('isLogin', true);
      Session::write('me', $exists->to_array());

      return new \SkyLogin\lib\platform\Status(
        array(
          'status' => true,
          'message' => 'USER_LOGIN_SUCCEEDED'
        )
      );

    }
    else
    {
      return new \SkyLogin\lib\platform\Status(
        array(
          'status' => false,
          'message' => 'USER_LOGIN_FAILED'
        )
      );
    }
  }

  public function user($id = null){
    return Session::get('me');
  }

  public function auth($callback = null){

    if(Session::has('isLogin') && Session::has('me') && Session::get('isLogin')){
      $this->isAuthorized = true;
    }

    if(!is_null($callback)){
      $callback(Session::get('me'));
    }
    
  }

  public function logout(){
    Session::destroy();
  }

}




