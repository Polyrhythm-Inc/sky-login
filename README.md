sky-login
=========

Sky-login is a login module library work as standalone.  

## Release Notes


## System Required Softwares
* php (must 5.3.0 or later)
* PDO Mysql
* mysql (recommend 5.5 or later)

*If you want to run tests, You have to install phpunit.
https://github.com/sebastianbergmann/phpunit/

## Installation

<b>!! Before enter commands written in bellow, You need to create database for Sky-login module.</b>
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

//If you want to use the role on sky-login, you need to set the path to your role configuration json file.
\SkyLogin\model\Role::setJsonPath('/path/to/your/role.json');

//initialize SkyLogin Module
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
    ),
    array(
        //Can add function to transaction block in this method.
        function($me){
            \SkyLogin\model\UserRole::add(array('user_id' => $me['id'], 'role_id' => 1));
        },
        function($me){
            \SkyLogin\model\UserDevice::add(.....
        }
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

#### enableAutoLoginWithDeviceId(Not implemented)
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


#### enableContainUserRoleData
If this configuration value is true, System attach user role data to $me(getable Platform::auth() callback arg) and return value of Platform::user()
<pre>Configure::write('enableContainUserRoleData', true);</pre>

#### enableAutoLoginWithCookie(Not implemented)
Can auto login, if cookie values for skylogin are transmited from client and they have verify value.
<pre>Configure::write('enableAutoLoginWithCookie', false);</pre>

#### cookieAuthExpires(Not implemented)
<pre>Configure::write('cookieAuthExpires', 86400);</pre>

#### cookieName(Not implemented)
<pre>Configure::write('cookieName', '__sltk__');</pre>



## Api reference

### \SkyLogin\Platform

#### auth([function callback])
<pre>
\SkyLogin\Platform::auth(function(){
    //some logic here...
});
</pre>

#### login(array $params)
<pre>
\SkyLogin\Platform::login(array(
    'email' => 'hogehoge',
    'password' => 'fugafuga'
));
</pre>

#### register(array $params, [array $addTransactions])
<b>Do registration based on $params.</b>  
If you want to add some logic in transaction block, you need to give function list to second arg. 
<pre>
\SkyLogin\Platform::login(array(
    'email' => 'hogehoge',
    'password' => 'fugafuga'
));
</pre>

#### void logout
Destruct all user data on session and cookie.
<pre>
\SkyLogin\Platform::logout();
</pre>

#### bool hasRole(mix $key)
##### Don't use this method if enableContainUserRoleData is disable.
<pre>
\SkyLogin\Platform::hasRole('admin'); // Serch based on role name from role.json .
\SkyLogin\Platform::hasRole(1); // Serch based on role id from role.json.
</pre>


### \SkyLogin\model

#### User
##### getByUserId(int $userid)
##### getByUserIdRelationSequenceId(int $sid)
##### getByNameAndEmailAndPasswd(string $name, string $email, string $password)
##### getByEmailAndPasswd(string email, string $password)
##### getByNameAndPasswd(string name, string $password)
--

#### UserDevice
##### getByUserId(int $userid)
##### getByOsTypeIdAndDeviceId(int $osTypeId, string $deviceid)
##### add(array $params)
--

#### UserRole
##### getByUserIdAndRoleId(int $userid, int $roleId)
##### delteByUserIdAndRoleId(int $osTypeId, string $deviceid)
##### add(array $params)
--

#### UserIdRelation
##### getByHashId(string $hashid)
##### add(array $params)

--
#### UserEachPlatformAuthentication
##### getByPlatformIdAndAuthToken(int $platformid, string $token)
##### add(array $params)
##### updateByPlatformIdAndUserId(array $params, int, $platformid, int $userid)
--

#### Role
##### getById(int $id)
--

## Run Test
<pre>
$ cd sky-login
$ export PHP_ENV=development && export SKY_LOGIN_DB_CONFIG_FILE_PATH=/path/to/your/test_db_config.php
$ phpunit test/
</pre>


## License
Hogehoge inc.
