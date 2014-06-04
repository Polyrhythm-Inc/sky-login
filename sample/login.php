<?php

include dirname(__FILE__) . '/base_setting.php';


\SkyLogin\Platform::auth();

$isAuthorized = \SkyLogin\Platform::isAuthorized();

if(!$isAuthorized){
  header('Location: /sky-login/sample/index.php');
  return;
}

$me = \SkyLogin\Platform::currentUser();

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

      <h4>Login Succeeded. Login as <?php echo $me->name;?>.</h4>
      <a href="/sky-login/sample/logout.php">Logout</a>

    </div> <!-- /container -->
  </body>
</html>
