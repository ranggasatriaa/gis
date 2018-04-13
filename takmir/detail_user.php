<?php
session_start();
require_once('../includes/request-key.php');
require_once('../includes/db-helper.php');

if(!isset($_SESSION[RequestKey::$USER_ID])) {
  header('Location: ../.');
}
else {
  $db = new DBHelper();
  $user    = $db->getUserById($_GET[RequestKey::$USER_ID]);
  $side_bar = 3;

}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Profil</title>

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
            <h2 class="no-margin-bottom">Detail User</h2>
          </div>
        </header>
        <!-- Dashboard Header Section    -->
        <section class="dashboard-header">
          <div class="container-fluid">
            <div class="row">
              <!-- Client Profile -->
              <div class="col-lg-12">
                <div class="client card">
                  <div class="card-body text-center">
                    <div class="client-avatar"><img src="../img/no_image_image.png" alt="..." class="img-fluid rounded-circle" style="height:100px; width: 100px; object-fit: contain;">
                      <div class="status bg-green"></div>
                    </div>
                    <div class="client-title">
                      <h3>Nama: <?=$user->user_name;?></h3><span>username: <?=$user->user_username;?></span>
                    </div>
                    <br>
                    <a href="edit_user.php?<?=RequestKey::$USER_ID?>=<?=$user->user_id?>" class="btn btn-primary">Ubah User</a>
                    <a href="edit_user_password.php?<?=RequestKey::$USER_ID?>=<?=$user->user_id?>" class="btn btn-primary">Ubah password</a>
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

</body>
</html>
