<?php

namespace lib\agent;


class BaseAgent {
  
  protected $isAuthorized = false;

  protected $req;

  public function isAuthorized(){
    return $this->isAuthorized;
  }

}