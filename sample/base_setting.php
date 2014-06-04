<?php

require_once __DIR__ . '/../vendor/autoload.php';

date_default_timezone_set('Asia/Tokyo');

require_once (dirname(__FILE__) . '/../SkyLogin.php');

\SkyLogin\Datastore::add('default', array(
    'adapter' => 'mysql',
    'host' => 'localhost',
    'port' => null,
    'user' => 'root',
    'passwd' => 'root',
    'db' => 'skylogin',
  )
);

\SkyLogin\Configure::write('securitySalt', 'o1ty8ha@-m^');

\SkyLogin\Configure::write('enableNameAuth', false);

\SkyLogin\Configure::write('enableUserhashId', true);


//initialization SkyLogin Module
\SkyLogin\Datastore::switchStore('default');
\SkyLogin\Platform::initialize('SessionLogin');
