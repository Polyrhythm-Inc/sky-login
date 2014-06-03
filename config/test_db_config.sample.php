<?php

\SkyLogin\lib\configure\Datastore::add('development', array(
    'host' => 'localhost',
    'port' => null,
    'user' => 'root',
    'passwd' => 'root',
    'db' => 'skylogin_test',
  )
);

\SkyLogin\lib\configure\Datastore::add('production', array(
    'host' => 'localhost',
    'port' => null,
    'user' => 'root',
    'passwd' => 'root',
    'db' => 'skylogin_test',
  )
);
