<?php

include dirname(__FILE__) . '/base_setting.php';

$req = new \SkyLogin\Request();

$stat = true;

if($req->isPost()) {
  if($req->post('user_name') !== "" && $req->post('password') !== "" && $req->post('email') !== ""){

    $userName = !is_null($req->post('user_name')) ? $req->post('user_name') : null;
    $email = !is_null($req->post('email')) ? $req->post('email') : null;
    $password = !is_null($req->post('password')) ? 
      sha1( $req->post('password') . \SkyLogin\lib\configure\Configure::get('securitySalt') ) : null;
    $role = !is_null($req->post('role')) ? $req->post('role') : 2;

    $status = \SkyLogin\Platform::register(
      array(
        'user_name' => $userName,
        'email' => $email,
        'password' => $password,
        'role' => $role,
        'hash_id' => sha1($userName . microtime() . mt_rand(0,1000))
      )
    );

    $stat = $status->status;

    if($stat){
      \SkyLogin\Platform::login(
        array(
          'login' => $userName
          , 'password' => $password
        ));
    }
  }
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
      <meta charset="utf-8">
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
        <?php if(!$stat):?>
          <p style="color:#ff0000;">ユーザーの登録に失敗しました。<br>既に登録されているユーザーか、不正な値が送信されました。</p>
        <?php endif;?>
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