<?php

namespace lib\platform\agent;

use lib\model\User;

abstract class BaseAgent {
  
  protected $isAuthorized = false;

  protected $isRegisterd = false;

  protected $req;

  public function isAuthorized(){
    return $this->isAuthorized;
  }
}