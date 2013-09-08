<?php

namespace SkyLogin\lib\platform\agent;

use SkyLogin\lib\model\User;

abstract class BaseAgent {
  
  protected $isAuthorized = false;

  protected $req;

  public function isAuthorized(){
    return $this->isAuthorized;
  }
}