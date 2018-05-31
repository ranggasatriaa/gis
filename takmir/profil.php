<?php
session_start();
require_once('../includes/request-key.php');
require_once('../includes/db-helper.php');

if(!isset($_SESSION[RequestKey::$USER_ID])) {
  header('Location: ../.');
}
if ($_SESSION[RequestKey::$USER_LEVEL] != 1){
  header('Location: ../unauthorize.php');
}
else {
  $db = new DBHelper();
  $side_bar = 4;

  $user    = $db->getUserById($_SESSION[RequestKey::$USER_ID]);
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
            <h2 class="no-margin-bottom">Profil</h2>
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
<!--                    <div class="client-avatar">-->
<!--                      <img src="../img/no_image_image.png" alt="..." class="img-fluid rounded-circle" style="height:100px; width: 100px; object-fit: contain;">-->
<!--                      <div class="status bg-green">-->
<!--                      </div>-->
<!--                    </div>-->
                    <div class="client-title">
                      <h3>Nana: <?=$user->user_name;?></h3>
                      <span>username: <?=$user->user_username;?></span>
                      <span>level: <?= $user->user_level==0 ? "Admin" : "Takmir" ?></span>
                    </div>
                    <br>
                    <a href="edit_profil.php?<?=RequestKey::$USER_ID?>=<?=$user->user_id?>" class="btn btn-primary">Ubah profil</a>
                    <a href="edit_password.php?<?=RequestKey::$USER_ID?>=<?=$user->user_id?>" class="btn btn-primary">Ubah password</a>
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
