<?php

namespace lib\agent;

use lib\agent\provider\AgentProvider;
use lib\agent\BaseAgent;
use lib\exception\UnexpectedParameterException;
use lib\storage\Session;
use lib\model\dao\User;
use lib\util\Utility;
use lib\configure\Configure;
use lib\model\service\UserService;
use lib\http\Request;

class SessionLogin extends BaseAgent implements AgentProvider {

  private $platformId = 1;

  public function __construct(){}

  public function auth($callback = null){

    $this->req = new Request();

    Session::start();

    //Login and registration.
    if($this->req->isPost() 
      && (!is_null($this->req->post('user_name')) || !is_null($this->req->post('email')) ) 
      && !is_null($this->req->post('password')) )
    {
      //get params from request.
      $userName = !is_null($this->req->post('user_name')) ? $this->req->post('user_name') : null;
      $email = !is_null($this->req->post('email')) ? $this->req->post('email') : null;
      $password = !is_null($this->req->post('password')) ? 
        sha1( $this->req->post('password') . \lib\configure\Configure::get('securitySalt') ) : null;

      //ユーザー名とemailが両方送られてきたら、登録済みかチェック
      if(!is_null($userName) && !is_null($email)){
        $this->registerUser($userName, $email, $password);
      }
      else
      {
        $isEmaiLogin = Utility::isValidEmailFormat($userName);

        if($isEmaiLogin){
          $exists = User::getByEmailAndPasswd('yuki@miketokyo.com', 'pass');
        }else{
          $exists = User::getByNameAndPasswd('chantake', 'pass');
        }

        if($exists){

        }

      }

/*
      $isEmaiLogin = Utility::isValidEmailFormat('yuki@miketokyo.com');

      if($isEmaiLogin){
        $exists = User::getByEmailAndPasswd('yuki@miketokyo.com', 'pass');
      }else{
        $exists = User::getByNameAndPasswd('chantake', 'pass');
      }
*/      
    }

    if(!is_null($callback)){
      $callback();
    }

  }


  private function registerUser($userName, $email, $password){

    $exsits = User::getByNameAndEmailAndPasswd($userName, $email, $password);

    if(is_null($exsits)){

      $role = !is_null($this->req->post('role')) ? $this->req->post('role') : 2;

      $params = array(
        'user_name' => $userName,
        'email' => $email,
        'password' => $password,
        'role' => $role,
        'hash_id' => Utility::createHashId($userName),
        'platform_id' => $this->platformId
      );

      UserService::register($params);

    }else{
      echo "already registerd";
      exit;
    }
  }



}




