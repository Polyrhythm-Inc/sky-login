<?php

require_once (dirname(__FILE__) . '/../SkyLogin.php');

\SkyLogin\Datastore::add('default', array(
    'adapter' => 'mysql',
    'host' => 'localhost',
    'port' => null,
    'user' => 'root',
    'passwd' => 'y_takei',
    'db' => 'skylogin',
  )
);


\SkyLogin\Configure::write('securitySalt', 'o1ty8ha@-m^');

\SkyLogin\Configure::write('enableNameAuth', false);

\SkyLogin\Configure::write('enableUserhashId', true);


//initialization SkyLogin Module
\SkyLogin\Datastore::switchStore('default');
\SkyLogin\Platform::initialize('SessionLogin');