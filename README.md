sky-login
=========

Sky-login is a login module library work as standalone.

## Requires
* php5.3.0(later)
* phpunit

## Installation
<pre>
$ git clone git@github.com:noppoMan/sky-login.git
$ cd sky-login
$ bin/migrate
</pre>

## Usage

### initialization
<pre>
&lt;?php

require 'SkyLogin.php';

use SkyLogin\SkyLogin;

\SkyLogin\Connection::add('default', array(
    'host' => 'localhost',
    'port' => null,
    'user' => 'user',
    'passwd' => 'pass',
    'db' => 'skylogin',
  )
);

\SkyLogin\Config::write('securitySalt', 'o1ty8ha@-m^');

//initialization SkyLogin Module
SkyLogin::initialize('SessionLogin');
</pre>

### Authentication
<pre>
SkyLogin::auth($_REQUET, function($me){
    
    //some logic here

});
</pre>
