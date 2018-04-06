
<?php
session_start();
require_once('../../includes/request-key.php');
require_once('../../includes/db-helper.php');

if(!isset($_SESSION[RequestKey::$USER_ID])) {
  header('Location: ../../.');
}
else {
  $status          = 0;
  $message         = '';
  $err_name        = '';
  $err_status      = '';
  $err_gender      = '';
  $err_born_place  = '';
  $err_born_date   = '';
  $err_education   = '';
  $err_salary      = '';
  $err_blood       = '';
  $db = new DBHelper();

  if(isset($_GET[RequestKey::$FAMILY_ID])){
    $fid = $db->escapeInput($_GET[RequestKey::$FAMILY_ID]);
    $family_old = $db->getFamilyById($fid);
    $pid = $family_old->place_id;
    if ($result = $db->deleteAnggota($fid)) {
      //MASUK DELETE
      $status = 1;
    }
    else {
      //GAGAL QUERY
      $status = 2;
    }

    // $place_id = $masjid->place_id;
  }else {
    header('location: ../place.php ');
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
          <li><a href="."> <i class="icon-home"></i>Dashboard </a></li>
          <li class="active"><a href="../place.php"> <i class="fa fa-map-o"></i>Place </a></li>
          <li><a href="profil.php"> <i class="icon-user"></i>Profil </a></li>
        </ul>
      </nav>
      <div class="content-inner">
        <!-- Page Header-->
        <header class="page-header">
          <div class="container-fluid">
            <h2 class="no-margin-bottom">Delete family</h2>
          </div>
        </header>
        <section class="dashboard-header">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-body">

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
  <?php
  // echo $status;
  // echo $message;
  include('foot.php');
  echo '<script>var status = '.$status.';</script>';
  $status = 0;
  // $message = '';
  ?>
  <script>
  $(document).ready(function() {
    if (status == 1) {
      swal("Success!","Berhasil menghapus anggota","success")
      .then((value) => {
        window.location.href = "detail_family.php?place-id=<?=$pid?>" + escape(window.location.href);
      })
    }
    else if (status == 2) {
      swal("Failed!","gagal query","error");
    }
    else if (status == 3) {
      swal("Failed!","Cek inputan","error");
    }
  });
  </script>
</body>
</html>
