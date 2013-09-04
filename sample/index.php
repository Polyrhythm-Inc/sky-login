<?php

include dirname(__FILE__) . '/base_setting.php';

$req = new \SkyLogin\Request();

$status = 0;

if($req->isPost() 
    && !is_null($req->post('user_name')) 
    && !is_null($req->post('password')) )
  {

  $userName = !is_null($req->post('user_name')) ? $req->post('user_name') : null;
  $password = !is_null($req->post('password')) ? 
    sha1( $req->post('password') . \SkyLogin\Configure::get('securitySalt') ) : null;

  $status = \SkyLogin\Platform::login(
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

?>

<html>
  <head>
      <link href="/sky-login/sample/css/bootstrap.css" rel="stylesheet">
      <style type="text/css">
        body {
          padding-top: 40px;
          padding-bottom: 40px;
          background-color: #f5f5f5;
        }

        .form-signin {
          max-width: 300px;
          padding: 19px 29px 29px;
          margin: 0 auto 20px;
          background-color: #fff;
          border: 1px solid #e5e5e5;
          -webkit-border-radius: 5px;
             -moz-border-radius: 5px;
                  border-radius: 5px;
          -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
             -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
                  box-shadow: 0 1px 2px rgba(0,0,0,.05);
        }
        .form-signin .form-signin-heading,
        .form-signin .checkbox {
          margin-bottom: 10px;
        }
        .form-signin input[type="text"],
        .form-signin input[type="password"] {
          font-size: 16px;
          height: auto;
          margin-bottom: 15px;
          padding: 7px 9px;
        }

    </style>
  </head>
  <body>
    <div class="container">

      <form class="form-signin" method="POST">
        <h2 class="form-signin-heading">Login</h2>

        <?php
          if($status == 2){
            echo "<p style='color:#ff0000'>ユーザー名かパスワードが間違っています。</p>";
          }
        ?>

        <input type="text" name="user_name" class="input-block-level" placeholder="User name or Email address">
        <input type="password" name="password" class="input-block-level" placeholder="Password">
        <label class="checkbox">
          <input type="checkbox" value="remember-me"> Remember me
        </label>
        <button class="btn btn-large btn-primary" type="submit" name="sub">Sign in</button>
        <br>
        <br>
        <a href="/sky-login/sample/register.php">Register user.</a>
      </form>
    </div> <!-- /container -->
  </body>
</html>