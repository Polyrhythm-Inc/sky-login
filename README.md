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

\SkyLogin\Datastore::add('default', array(
    'host' => 'localhost',
    'port' => null,
    'user' => 'user',
    'passwd' => 'pass',
    'db' => 'skylogin',
  )
);

\SkyLogin\Configure::write('securitySalt', 'o1ty8ha@-m^');

//initialization SkyLogin Module
\SkyLogin\Platform::initialize('SessionLogin');
</pre>

### Authentication
<pre>
$req = new \SkyLogin\Request();

if($req->isPost() 
    && !is_null($req->post('user_name')) 
    && !is_null($req->post('email')) 
    && !is_null($req->post('password')) )
  {

  //handle request
  $userName = $req->post('user_name');
  $email = $req->post('email');
  $password = sha1( $req->post('password') . SkyLogin\Configure::get('securitySalt') );
  $role = $req->post('role');
  
  //user registration
  $status = \SkyLogin\Platform::register(
    array(
      'user_name' => $userName,
      'email' => $email,
      'password' => $password,
      'role' => $role,
      'hash_id' => sha1($userName . microtime() . mt_rand(0,1000))
    )
  );

  //login
  \SkyLogin\Platform::login(
    array(
      'login' => $userName
      , 'password' => $password
    ));
}

\SkyLogin\Platform::auth(function($me){

    $isAuthorized = \SkyLogin\Platform::isAuthorized();

    if($isAuthorized){
      header('Location: /sky-login/sample/login.php');
    }

});
</pre>
