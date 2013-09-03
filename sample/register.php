<?php
  include dirname(__FILE__) . '/base_setting.php';


  //authorization
  //SkyLogin::auth($_REQUEST);

  if(isset($_POST['sub'])){
    \SkyLogin\Platform::auth($_REQUEST);     
  }

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
        <h2 class="form-signin-heading">User registration</h2>
        <input type="text" name="user_name" class="input-block-level" placeholder="User name">
        <input type="text" name="email" class="input-block-level" placeholder="Email address">
        <input type="password" name="password" class="input-block-level" placeholder="Password">
        <label class="checkbox">
          <input type="checkbox" value="remember-me"> Remember me
        </label>
        <button class="btn btn-large btn-primary" type="submit" name="sub">Sign in</button>
      </form>

    </div> <!-- /container -->
  </body>
</html>