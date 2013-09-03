<?php

namespace lib\agent;

use lib\model\User;

abstract class BaseAgent {
  
  protected $isAuthorized = false;

  protected $req;

  public function isAuthorized(){
    return $this->isAuthorized;
  }
}