<?php

namespace SkyLogin\platform\provider;

interface AgentProvider {

  public function register($params = array(), $addTransactions = array());

  public function login($params = array());

  public function auth($callback = null);

  public function currentUser();

  public function refreshCurrentUser();

  public function logout();

}
