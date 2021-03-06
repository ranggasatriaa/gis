<?php
session_start();
require_once('../includes/request-key.php');
require_once('../includes/db-helper.php');

$err_name = '';
$err_username = '';
$side_bar = 3;

$status = 0;
$message = '';

if(!isset($_SESSION[RequestKey::$USER_ID])) {
  header('Location: ../.');
}if ($_SESSION[RequestKey::$USER_LEVEL] != 0){
  header('Location: ../unauthorize.php');
}
else {
  $db   = new DBHelper();
  if (isset($_GET[RequestKey::$USER_ID])) {
    $uid  = $_GET[RequestKey::$USER_ID];
    $user = $db->getUserById2($uid);
    $masjids = $db->getAllMasjid2();
  }elseif (isset($_POST[RequestKey::$USER_ID])) {
    $uid  = $_POST[RequestKey::$USER_ID];
    $user = $db->getUserById2($uid);
    $masjids = $db->getAllMasjid2();
  }else {
    header('Location: user.php');
  }

  //VALIDASI
  if(isset($_POST[RequestKey::$USER_NAME]) && isset($_POST[RequestKey::$USER_USERNAME])){
    $user_id        = $db->escapeInput($_POST[RequestKey::$USER_ID]);
    $user_name      = $db->escapeInput($_POST[RequestKey::$USER_NAME]);
    $user_username  = $db->escapeInput($_POST[RequestKey::$USER_USERNAME]);
    $user_masjid_id = $db->escapeInput($_POST[RequestKey::$USER_MASJID_ID]);

    if (!preg_match("/^[a-zA-Z ]{1,50}$/",$user_name)) {
      $err_name = "Nama tidak valid";
    }

    if (!preg_match("/^[a-zA-Z0-9]{1,50}$/",$user_username)) {
      $err_username = "Nama tidak valid";
    }

    if(empty($err_name) && empty($err_username)){
      $array = array();
      $array[RequestKey::$USER_ID]        = $db->escapeInput($uid);
      $array[RequestKey::$USER_NAME]      = $db->escapeInput($_POST[RequestKey::$USER_NAME]);
      $array[RequestKey::$USER_USERNAME]  = $db->escapeInput($_POST[RequestKey::$USER_USERNAME]);
      $array[RequestKey::$USER_MASJID_ID] = $db->escapeInput($_POST[RequestKey::$USER_MASJID_ID]);

      // print_r($array);
      // die();
      if ($db->updateUser($array)) {
        $status = 1;
      }
      else {
        $status = 2;
        $message = "Gagal Query";
      }
    }
    else {
      $status = 2;
      $message = "Cek Inputan";
    }
  }
}

?>
<!DOCTYPE html>
<html>
<head>
  <title>Edit profil</title>
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
            <h2 class="no-margin-bottom">Edit profil</h2>
          </div>
        </header>
        <!-- Dashboard Header Section    -->
        <section class="dashboard-header">
          <div class="container-fluid">
            <div class="row">
              <!-- Horizontal Form-->
              <div class="col-lg">
                <div class="card">
                  <div class="card-body">
                    <form class="form-horizontal" action="edit_user.php?user_id=<?=$uid?>" method= "post" enctype="multipart/form-data">
                      <div class="form-group row">
                        <label class="col-sm-3 form-control-label">Nama</label>
                        <div class="col-sm-9">
                          <input id="inputHorizontalSuccess" name="<?= RequestKey::$USER_NAME ?>" type="text" placeholder="Nama" class="form-control form-control-success" value="<?= $user->user_name?>" required>
                          <small class="form-text <?=($err_name != "" ? 'text-danger' : '')?>"><?=($err_name != "" ? $err_name : 'Karakter huruf dan spasi.')?></small>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-3 form-control-label">User Name</label>
                        <div class="col-sm-9">
                          <input id="inputHorizontalSuccess" name="<?= RequestKey::$USER_USERNAME ?>" type="text" placeholder="Nama" class="form-control form-control-success" value="<?= $user->user_username?>" required>
                          <small class="form-text <?=($err_username != "" ? 'text-danger' : '')?>"><?=($err_username != "" ? $err_username : 'Karakter huruf dan angka tanpa spasi.')?></small>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-3 form-control-label ">Takmir Masjid</label>
                        <div class="col-sm-9">
                          <select class="form-control" name="<?=RequestKey::$USER_MASJID_ID?>" required>
                            <option value=""> - Pilih - </option>
                            <?php while ($masjid = $masjids->fetch_object()){
                              ?>
                              <option <?=$user->masjid_id == $masjid->masjid_id ? 'selected' :''?> value="<?=$masjid->masjid_id?>">
                                <?=ucwords($masjid->masjid_name)?>
                                </option>
                              <?php
                            }
                             ?>
                          </select>
                          <small class="form-text <?=($err_username != "" ? 'text-danger' : '')?>"><?=($err_username != "" ? $err_username : 'Pilih Masjid lokasi takmir.')?></small>
                        </div>
                      </div>
                      <div class="form-group row">
                        <div class="col-sm-9 offset-sm-3">
                          <input type="hidden" name="<?= RequestKey::$USER_ID ?>" value="<?=$uid?>">
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
      swal("Success!","","success").then((value) => {
        window.location.href = "detail_user.php?user-id=<?=$uid?>" + escape(window.location.href);
      });
    }
    else if (status == 2) {
      swal("Failed!",message,"error");
    }
  });
  </script>

  <script>
  function readURL(input){
    var reader = new FileReader();
    reader.onload = function(e){
      $('#img_prev').attr('src',e.target.result);
    }
    reader.readAsDataURL(input.files[0]);
  }
  $("#image").change(function(){
    readURL(this);
  })
</script>

</body>
</html>
