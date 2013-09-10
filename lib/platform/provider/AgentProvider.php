<?php

namespace SkyLogin\lib\platform\provider;

interface AgentProvider {

  public function register($params = array(), $addTransactions = array());

  public function login($params = array());

  public function auth($callback = null);

  public function user($id = null);

  public function logout();

}