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

  private static $currentUser = null;

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

    $password = sha1( $params['password'] . \SkyLogin\Configure::get('securitySalt') );

    $enableEmailAuth = Configure::get('enableEmailAuth');
    $enableNameAuth = Configure::get('enableNameAuth');

    if($enableEmailAuth && $enableNameAuth){

      $isEmaiLogin = Utility::isValidEmailFormat($params['login']);
      if($isEmaiLogin){
        $exists = User::getByEmailAndPasswd($params['login'], $password);
      }else{
        $exists = User::getByNameAndPasswd($params['login'], $password);
      }
    }
    else if (!$enableEmailAuth && $enableNameAuth){
      $exists = User::getByNameAndPasswd($params['login'], $password);

    }
    else
    {
      //default
      $exists = User::getByNameAndPasswd($params['login'], $password);
    }

    if(!empty($exists)){
      Session::write('isLogin', true);
      Session::write('me.id', $exists->id);
      $this->auth();

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

  public function refreshCurrentUser(){
    self::$currentUser = User::getByUserId(self::$currentUser->id);
    return self::$currentUser;
  }

  public function currentUser(){
    return self::$currentUser;
  }

  public function auth($callback = null){

    if(Session::has('isLogin') && Session::has('me.id') && Session::get('isLogin')){
      $this->isAuthorized = true;
      if(is_null(self::$currentUser)){
        self::$currentUser = User::getByUserId(Session::get('me.id'));
      }
    }

    if(!is_null($callback)){
      $callback(self::$currentUser);
    }
  }

  public function logout(){
    Session::destroy();
  }

}
