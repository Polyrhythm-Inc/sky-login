<?php

require_once (dirname(__FILE__) . '/../SkyLogin.php');

use SkyLogin\SkyLogin;
use SkyLogin\Connection;
use SkyLogin\Config;

Connection::add('default', array(
    'host' => 'localhost',
    'port' => null,
    'user' => 'root',
    'passwd' => 'y_takei',
    'db' => 'skylogin',
  )
);

Config::write('securitySalt', 'o1ty8ha@-m^');

//initialization SkyLogin Module
SkyLogin::initialize('SessionLogin');

//authorization
SkyLogin::auth($_REQUEST);