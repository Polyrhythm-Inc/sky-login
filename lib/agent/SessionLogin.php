<?php

namespace lib\agent;

use lib\agent\provider\AgentProvider;
use lib\agent\BaseAgent;
use lib\exception\UnexpectedParameterException;
use lib\storage\Session;
use lib\model\dao\User;
use lib\util\Utility;

class SessionLogin extends BaseAgent implements AgentProvider {

  private $platformId = 1;

  public function __construct(){}

  public function auth($req = array(), $callback = null){

    $this->req = $req;

    Session::start();

    if(isset($this->req['user_name']) && isset($this->req['password'])){
      $userName = $this->req['user_name'];
      $password = $this->req['password'];


      $isEmaiLogin = Utility::isValidEmailFormat('yuki@miketokyo.com');

      $exists = false;

      if($isEmaiLogin){
        $exists = User::getByEmailAndPasswd('yuki@miketokyo.com', 'pass');
      }else{
        $exists = User::getByNameAndPasswd('chantake', 'pass');
      }
      
    }

    //var_dump($exists);

    if(!is_null($callback)){
      $callback();
    }

  }

}