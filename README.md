sky-login
=========

Sky-login is a login module library work as standalone.  

## Release Notes
Sep 06 2013 - alpha release.


## System Required Softwares
* php (must 5.3.0 or later)
* PDO Mysql module
* mysql (recommend 5.5 or later)

*If you want to run tests, You have to install phpunit.
https://github.com/sebastianbergmann/phpunit/

## Installation

<b>!! Before enter commands written in bellow, You have to create database for Sky-login module.</b>
<pre>
$ git clone git@github.com:noppoMan/sky-login.git
$ cd sky-login
$ bin/sl migrate -c username:password@localhost[:port]/dbname
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


## Explanation of configuration value.
<b>Writte in lib/config/core.php default.</b>

#### securitySalt
To use in order to complicate the password.
<pre>Configure::write('securitySalt', '76hba¥^-/:[peyu64@jhk*a1');</pre>


#### enableUserhashId
Enable this option, if you want to use user_id which is not a auto increment value.  
System will generate randome hashid and add it to user_id_relations table which relates users.user_id_relation_sequence_id.
<pre>Configure::write('enableUserhashId', true);</pre>

#### enableAutoLoginWithDeviceId
Can auto login, when device_id and platform_id(ios or android) are transmited from client.
<pre>Configure::write('enableAutoLoginWithDeviceId', false);</pre>

#### enableEmailAuth
Enable email based authentication
<pre>Configure::write('enableEmailAuth', true);</pre>

#### enableNameAuth
Enable name based authentication
<pre>Configure::write('enableNameAuth', true);</pre>

##### additianla info
If both of enableEmailAuth and enableNameAuth are 'true', You can login either email or user_name.

#### enableAutoLoginWithCookie
Can auto login, if cookie values for skylogin are transmited from client and they have verify value.
<pre>Configure::write('enableAutoLoginWithCookie', false);</pre>

#### cookieAuthExpires
<pre>Configure::write('cookieAuthExpires', 86400);</pre>

#### cookieName
<pre>Configure::write('cookieName', '__sltk__');</pre>


## Run Test
<pre>
$ cd sky-login
$ phpunit test/
</pre>


## License
Hogehoge inc.
