<?php
session_start();
require_once('../includes/request-key.php');
require_once('../includes/db-helper.php');

//VALIDASI
$err_pw_1 = '';
$err_pw_2 = '';
$err_pw_3 = '';
$side_bar = 3;

$status = 0;
$message = '';

if(!isset($_SESSION[RequestKey::$USER_ID])) {
  header('Location: ../.');
}if ($_SESSION[RequestKey::$USER_LEVEL] != 0){
  header('Location: ../unauthorize.php');
}
else {
  //DB
  $db   = new DBHelper();
  if ($_GET[RequestKey::$USER_ID]) {
    $uid  = $_GET[RequestKey::$USER_ID];
    $user = $db->getUserById($uid);
  }else {
    header('Location: user.php');
  }

  if(isset($_POST['password-lama']) && isset($_POST['password-baru']) && isset($_POST['password-baru-2'])) {
    $password_lama    = $db->escapeInput($_POST['password-lama']);
    $password_baru    = $db->escapeInput($_POST['password-baru']);
    $password_baru_2  = $db->escapeInput($_POST['password-baru-2']);

    if (!preg_match("/^[a-zA-Z0-9]{8,20}$/",$password_lama)) {
      $err_pw_1 = "Input tidak valid";
    }

    if (!preg_match("/^[a-zA-Z0-9]{8,20}$/",$password_baru)) {
      $err_pw_2 = "Input tidak valid";
    }

    if (!preg_match("/^[a-zA-Z0-9]{8,20}$/",$password_baru_2)) {
      $err_pw_3 = "Input tidak valid";
    }

    if (empty($err_pw_1) && empty($err_pw_2) && empty($err_pw_3)) {
      if (sha1($password_lama) == $user->user_password) {
        if ($password_baru == $password_baru_2) {
          if($db->changePassword($uid,sha1($password_baru))){
            $status = 1;
            $message = "Berhasil Menganti Password";
          }else {
            $status = 2;
            $message = $db->strBadQuery;
          }
        }else {
          $status = 2;
          $message = "Cek Inputan";
          $err_pw_3 = "Konfirmasi password tidak sesuai";
        }
      }
      else{
        $status = 2;
        $message = "Cek Inputan";
        $err_pw_1 = "Password lama salah";
      }
    }
  }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Edit password</title>

  <?php include('head.php'); ?>

</head>
<body>
  <div class="page">

    <?php include('main-navbar.php'); ?>

    <div class="page-content d-flex align-items-stretch">
      <?php include('side-navbar.php') ?>

      <div class="content-inner">
        <!-- Page Header-->
        <header class="page-header">
          <div class="container-fluid">
            <h2 class="no-margin-bottom">Edit password</h2>
          </div>
        </header>
        <!-- Dashboard Header Section    -->
        <section class="dashboard-header">
          <div class="container-fluid">
            <div class="row">
              <!-- Horizontal Form-->
              <div class="col-lg-6">
                <div class="card">
                  <div class="card-body">
                    <form class="form-horizontal" method= "post">
                      <div class="form-group row">
                        <label class="col-sm-3 form-control-label">Password Lama</label>
                        <div class="col-sm-9">
                          <input name="password-lama" type="password" placeholder="Password lama" class="form-control form-control-success"><small class="form-text <?=($err_pw_1 != "" ? 'text-danger' : '')?>"><?=($err_pw_1 != "" ? $err_pw_1 : 'Karakter huruf dan angka min.8 dan max 20.')?></small>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-3 form-control-label">Password Baru</label>
                        <div class="col-sm-9">
                          <input name="password-baru" type="password" placeholder="Password baru" class="form-control form-control-success"><small class="form-text <?=($err_pw_2 != "" ? 'text-danger' : '')?>"><?=($err_pw_2 != "" ? $err_pw_2 : 'Karakter huruf dan angka min.8 dan max 20.')?></small>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-3 form-control-label">Konfirmasi password</label>
                        <div class="col-sm-9">
                          <input name="password-baru-2" type="password" placeholder="Pasword" class="form-control form-control-warning"><small class="form-text <?=($err_pw_3 != "" ? 'text-danger' : '')?>"><?=($err_pw_3 != "" ? $err_pw_3 : 'Karakter huruf dan angka min.8 dan max 20.')?></small>
                        </div>
                      </div>
                      <div class="form-group row">
                        <div class="col-sm-9 offset-sm-3">
                          <a href="detail_user.php?user-id=<?=$uid?>" class="btn btn-secondary">Cancel</a>
                          <button value="submit" name="submit" class="btn btn-primary">Submit</button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>

        <?php include('page-footer.php'); ?>

      </div>
    </div>
  </div>

  <?php include('foot.php'); ?>
  <?php
  echo '<script>var status = '.$status.'; var message = "'.$message.'";</script>';
  $status = 0;
  ?>

  <script>
  $(document).ready(function() {
    if (status == 1) {
      swal("Success!",message,"success").then((value) => {
        window.location.href = "detail_user.php?user-id=<?=$uid?>" + escape(window.location.href);
      });
    }
    else if (status == 2) {
      swal("Failed!",message,"error");
    }
  });
  </script>

</body>
</html>
