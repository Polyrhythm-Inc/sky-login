<?php

namespace lib\agent\provider;

interface AgentProvider {

  public function auth($req = array(), $callback = null);

}