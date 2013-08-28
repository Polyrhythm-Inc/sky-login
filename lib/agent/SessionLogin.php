<?php

namespace lib\agent;

use lib\agent\provider\AgentProvider;
use lib\agent\BaseAgent;

class SessionLogin extends BaseAgent implements AgentProvider {

  private $platformId = 1;

  public function __construct(){

  }

  public function auth($callback){

  }

}