<?php

namespace SkyLogin\platform\agent;

use SkyLogin\platform\provider\AgentProvider;
use SkyLogin\platform\agent\BaseAgent;
use SkyLogin\exception\UnexpectedParameterException;
use SkyLogin\storage\Session;
use SkyLogin\model\User;
use SkyLogin\util\Utility;
use SkyLogin\Configure;
use SkyLogin\model\UserService;
use SkyLogin\http\Request;

Session::start();

class SessionLogin extends BaseAgent implements AgentProvider {

  private $platformId = 1;

  public function register($params = array(), $addTransactions = array()){

    $exsits = User::getByNameAndEmailAndPasswd($params['user_name'], $params['email'], $params['password']);

    if(is_null($exsits)){

      $data = array(
        'user_name' => $params['user_name'],
        'email' => $params['email'],
        'password' => $params['password'],
        'role' => $params['role'],
        'platform_id' => $this->platformId,
        'hash_id' => isset($params['hash_id']) ? $params['hash_id'] : null
      );

      if(isset($params['display_name'])){
        $data['display_name'] = $params['display_name'];
      }

      try{

        $user = UserService::register($data, $addTransactions);

      }catch(\Exception $e){
        if(preg_match('/Duplicate entry/', $e->__toString())){
          return new \SkyLogin\platform\Status(
            array(
              'status' => false,
              'message' => 'DUPLICATE_ENTRY',
            )
          );
        }
        throw $e;
      }

      return new \SkyLogin\platform\Status(
        array(
          'status' => true,
          'message' => 'USER_REGISTRATION_SUCCEEDED'
        )
      );

    }else{

      return new \SkyLogin\platform\Status(
        array(
          'status' => false,
          'message' => 'REGISTER_USER_ALREADY_EXSITS'
        )
      );

    }
  }

  //deviceid
  public function autoLogin($params = array()){

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
      $exists = User::getByNameAndPasswd($params['login'], $params['password']);
    }

    if(!is_null($exists)){
      Session::write('isLogin', true);
      Session::write('me', $exists->to_array());

      return new \SkyLogin\platform\Status(
        array(
          'status' => true,
          'message' => 'USER_LOGIN_SUCCEEDED'
        )
      );

    }
    else
    {
      return new \SkyLogin\platform\Status(
        array(
          'status' => false,
          'message' => 'USER_LOGIN_FAILED'
        )
      );
    }
  }

  public function refresh_current_user(){
    Session::write('me', \SkyLogin\model\User::getByUserId(Session::get('me')['id'])->to_array());
    return Session::get('me');
  }

  public function current_user($id = null){
    return Session::get('me');
  }

  public function auth($callback = null){

    if(Session::has('isLogin') && Session::has('me') && Session::get('isLogin')){
      $this->isAuthorized = true;
      parent::decorateUserData();
    }

    if(!is_null($callback)){
      $callback(Session::get('me'));
    }
  }

  public function logout(){
    Session::destroy();
  }

}
