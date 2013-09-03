<?php

namespace lib\agent\provider;

interface AgentProvider {

  public function auth($callback = null);

}