<?php
session_start();
require_once('../includes/request-key.php');
require_once('../includes/db-helper.php');

if(!isset($_SESSION[RequestKey::$USER_ID])) {
  header('Location: ../.');
}
else {
  $db = new DBHelper();
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
      <!-- Side Navbar -->
      <nav class="side-navbar">
        <!-- Sidebar Header-->
        <div class="sidebar-header d-flex align-items-center">
          <div class="avatar"><img src="../img/no_image_image.png" alt="..." class="img-fluid rounded-circle" style="height:55px; width: 55px; object-fit: contain;"></div>
          <div class="title">
            <h1 class="h4">ADMIN</h1>
          </div>
        </div>
        <!-- Sidebar Navidation Menus--><span class="heading">Main</span>
        <ul class="list-unstyled">
          <li><a href="."> <i class="icon-home"></i>Dashboard </a></li>
          <li><a href="place.php"> <i class="fa fa-map-o"></i>Place </a></li>
          <li class="active"><a href="profil.php"> <i class="icon-user"></i>Profil </a></li>
        </ul>
      </nav>
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
                    <div class="client-avatar"><img src="../img/no_image_image.png" alt="..." class="img-fluid rounded-circle" style="height:100px; width: 100px; object-fit: contain;">
                      <div class="status bg-green"></div>
                    </div>
                    <div class="client-title">
                      <h3><?=$user->user_name;?></h3><span><?=$user->user_username;?></span>
                    </div>
                    <br>
                    <a href="edit_profil.php" class="btn btn-primary">Ubah profil</a>
                    <a href="edit_password.php" class="btn btn-primary">Ubah password</a>
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
