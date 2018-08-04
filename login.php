<?php
session_start();
require_once('includes/request-key.php');
require_once('includes/db-helper.php');

$alert = false;

if(isset($_SESSION[RequestKey::$USER_LEVEL])) {
  if ($_SESSION[RequestKey::$USER_LEVEL == 0]) {
  }else {
    header('Location: takmir/');
  }
}
else {

  if (isset($_POST['submit'])) {
    if(isset($_POST[RequestKey::$USER_USERNAME]) && isset($_POST[RequestKey::$USER_PASSWORD])) {
      $db = new DBHelper();
      $username   = $db->escapeInput($_POST[RequestKey::$USER_USERNAME]);
      $password = $db->escapeInput($_POST[RequestKey::$USER_PASSWORD]);

      if (empty($username)) {
        $err_login = "Username tidak boleh kosong";
      }

      if (empty($password)) {
        $err_login = "Password tidak boleh kosong";
      }

      if (empty($err_login)) {
        if($user = $db->login($username,$password)){
          $_SESSION[RequestKey::$USER_ID]      = $user->user_id;
          $_SESSION[RequestKey::$USER_LEVEL]   = $user->user_level;
          if ($user->user_level == 0){
            header('Location: admin/');
          }elseif($user->user_level == 1){
            header('Location: takmir/');
          }else{
            header('Location: .');
          }
        }
        else {
          $err_login = "invalid username or password";
        }
      }
    }
  }
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Login Arsip Keluarga</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="robots" content="all,follow">
  <!-- Bootstrap CSS-->
  <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome CSS-->
  <link rel="stylesheet" href="vendor/font-awesome/css/font-awesome.min.css">
  <!-- Fontastic Custom icon font-->
  <link rel="stylesheet" href="css/fontastic.css">
  <!-- Google fonts - Poppins -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,700">
  <!-- theme stylesheet-->
  <link rel="stylesheet" href="css/style.default.css" id="theme-stylesheet">
  <!-- Favicon-->
  <link rel="shortcut icon" href="img/favicon.ico">
  <!-- Tweaks for older IEs--><!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
</head>
<body>
  <div class="page login-page">
    <div class="container d-flex align-items-center">
      <div class="form-holder has-shadow">
        <div class="row">
          <!-- Logo & Information Panel-->
          <div class="col-lg-6">
            <div class="info d-flex align-items-center">
              <div class="content">
                <div class="logo">
                  <h1>Dashboard</h1>
                </div>
                <p>Arsip Keluarga</p>
              </div>
            </div>
          </div>
          <!-- Form Panel    -->

          <div class="col-lg-6 bg-white">
            <div class="form d-flex align-items-center">
              <div class="content">
                <form id="login-form" action="login.php" method="post">
                  <div class="form-group">
                    <!-- <label>
                    username: admin - pass: admin123 <br>
                    username: takmir - pass: takmir123 <br>
                  </label> -->
                  </div>
                  <div class="form-group">
                    <input id="login-email" type="username" name="<?=RequestKey::$USER_USERNAME?>" required="" class="input-material" autofocus>
                    <label for="login-email" class="label-material">Username</label>
                  </div>
                  <div class="form-group">
                    <input id="login-password" type="password" name="<?=RequestKey::$USER_PASSWORD?>" required="" class="input-material">
                    <label for="login-password" class="label-material">Password</label>
                  </div>
                  <?= (!empty($err_login)) ? '<p class="text-danger">'.$err_login.'</p>' : '' ?>
                  <button id="login" name="submit" class="btn btn-primary">Login</button>
                </form>
<!--                <a href="forget-password.php" class="forgot-pass">Forgot Password?</a><br><small>Do not have an account? </small><a href="register.php" class="signup">Signup</a>-->
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="copyrights text-center">
      <p>Design by <a href="https://bootstrapious.com/admin-templates" class="external">Bootstrapious</a>
        <!-- Please do not remove the backlink to us unless you support further theme's development at https://bootstrapious.com/donate. It is part of the license conditions. Thank you for understanding :)-->
      </p>
    </div>
  </div>
  <!-- JavaScript files-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/popper.js/umd/popper.min.js"> </script>
  <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
  <script src="vendor/jquery.cookie/jquery.cookie.js"> </script>
  <script src="vendor/chart.js/Chart.min.js"></script>
  <script src="vendor/jquery-validation/jquery.validate.min.js"></script>
  <!-- Main File-->
  <script src="js/front.js"></script>
</body>
</html>
