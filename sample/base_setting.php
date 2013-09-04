<?php

require_once (dirname(__FILE__) . '/../SkyLogin.php');

\SkyLogin\Datastore::add('default', array(
    'host' => 'localhost',
    'port' => null,
    'user' => 'root',
    'passwd' => 'y_takei',
    'db' => 'skylogin',
  )
);


$conf = \SkyLogin\Datastore::get('default');

\SkyLogin\Configure::write('securitySalt', 'o1ty8ha@-m^');

//initialization SkyLogin Module
\SkyLogin\Platform::initialize('SessionLogin');