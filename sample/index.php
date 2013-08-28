<?php

require_once (dirname(__FILE__) . '/../SkyLogin.php');

use SkyLogin\SkyLogin;

//initialization SkyLogin Module
SkyLogin::initialize('SessionLogin');

SkyLogin::auth();

?>

<html>
  <head>
  </head>
  <body>
    <h1>SkyLogin Sample</h1>
    <form action="/skylogin/sample/login.php" method="post">
      user name: <input type="text" name="user_name" value="" placeholder="username">
      <br>
      password: <input type="password" name="passwd" value="" placeholder="password">
      <br><br>

      <input type="submit" name="btn" value="login">

    </form>
  </body>
</html>