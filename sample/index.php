<?php
  include dirname(__FILE__) . '/base_setting.php';
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