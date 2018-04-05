
<?php
session_start();
require_once('../../includes/request-key.php');
require_once('../../includes/db-helper.php');

if(!isset($_SESSION[RequestKey::$USER_ID])) {
  header('Location: ../../.');
}
else {
  $db = new DBHelper();
  if(isset($_GET[RequestKey::$KAJIAN_ID])){
    $kid = $db->escapeInput($_GET[RequestKey::$KAJIAN_ID]);
    $kajian = $db->getKajianById($kid);
    $kajian_masjid_id_old = $kajian->masjid_id;
    if ($result = $db->deleteKajian($kid)) {
      $status = 1;
    }
    else{
      //error create
      $status = 2;
    }
  }
  else {
      $status = 3;
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Geocoding service</title>
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
          <div class="avatar"><img src="../../img/no_image_image.png" alt="..." class="img-fluid rounded-circle" style="height:55px; width: 55px; object-fit: contain;"></div>
          <div class="title">
            <h1 class="h4">ADMIN</h1>
          </div>
        </div>
        <!-- Sidebar Navidation Menus--><span class="heading">Main</span>
        <ul class="list-unstyled">
          <li><a href="../."> <i class="icon-home"></i>Dashboard </a></li>
          <li class="active"><a href="../place.php"> <i class="fa fa-map-o"></i>Place </a></li>
          <li><a href="../profil.php"> <i class="icon-user"></i>Profil </a></li>
        </ul>
      </nav>
      <div class="content-inner">
        <!-- Page Header-->
        <header class="page-header">
          <div class="container-fluid">
            <h2 class="no-margin-bottom">Delete Kajian</h2>
          </div>
        </header>
        <?php include('page-footer.php'); ?>
      </div>
    </div>
  </div>
  <?php
  include('foot.php');
  echo '<script>var status = '.$status.'</script>';
  $status = 0;
  ?>
  <script>
  $(document).ready(function() {
    if (status == 1) {
      swal("Success!","Delete Success","success")
      .then((value) => {
        window.location.href = "detail_masjid.php?place-id=<?=$kajian_masjid_id_old?>" + escape(window.location.href);
      });
    }
    else if (status == 2) {
      swal("Failed!","Tidak bisa masuk query","error");
      window.location.href = "detail_masjid.php?place-id=<?=$kajian_masjid_id_old?>" + escape(window.location.href);
    }
    else if (status == 3) {
      swal("Failed!","Id Kajian tidak ditemukan","error");
      window.location.href = ".";

    }
  });
  </script>
</body>
</html>
