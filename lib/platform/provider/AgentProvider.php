<?php

namespace SkyLogin\platform\provider;

interface AgentProvider {

  public function register($params = array(), $addTransactions = array());

  public function login($params = array());

  public function auth($callback = null);

  public function current_user();

  public function refresh_current_user();

  public function logout();

}
