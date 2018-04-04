
<?php
session_start();
require_once('../includes/request-key.php');
require_once('../includes/db-helper.php');

if(!isset($_SESSION[RequestKey::$USER_ID])) {
  header('Location: ../.');
}
else {
  $status       = 0;
  $err_name     = '';
  $err_location = '';
  $err_history  = '';

  if(isset($_POST[RequestKey::$PLACE_NAME]) && isset($_POST[RequestKey::$PLACE_LOCATION]) && isset($_POST[RequestKey::$MASJID_HISTORY])){
    echo "masuk if iset | ";
    $db = new DBHelper();

    //escapeInput
    $place_name     = $db->escapeInput($_POST[RequestKey::$PLACE_NAME]);
    $place_location = $db->escapeInput($_POST[RequestKey::$PLACE_LOCATION]);
    $place_category = 0;
    $masjid_name    = $db->escapeInput($_POST[RequestKey::$PLACE_NAME]);
    $masjid_history = $db->escapeInput($_POST[RequestKey::$MASJID_HISTORY]);

    //CEK ERROR PADA INPUTAN
    if(empty($err_name) && empty($err_location) && empty($err_history)){
      echo "masuk error | ";
      $array_place = array();
      $array_place[RequestKey::$PLACE_NAME]     = $place_name;
      $array_place[RequestKey::$PLACE_LOCATION] = $place_location;
      $array_place[RequestKey::$PLACE_CATEGORY] = $place_category;
      print_r($array_place);
      if ($place = $db->createPlace($array_place)) {
        echo "masuk create place | ";
        $status = 1;
      }
      else{
        //error create
        $status = 3;
      }
    }
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
          <div class="avatar"><img src="../assets/user_img/user/no_image_image.png" alt="..." class="img-fluid rounded-circle" style="height:55px; width: 55px; object-fit: contain;"></div>
          <div class="title">
            <h1 class="h4">ADMIN</h1>
          </div>
        </div>
        <!-- Sidebar Navidation Menus--><span class="heading">Main</span>
        <ul class="list-unstyled">
          <li class="active"><a href="."> <i class="icon-home"></i>Dashboard </a></li>
          <li><a href="place.php"> <i class="fa fa-map-o"></i>Place </a></li>
          <li><a href="profil.php"> <i class="icon-user"></i>Profil </a></li>
        </ul>
      </nav>
      <div class="content-inner">
        <!-- Page Header-->
        <header class="page-header">
          <div class="container-fluid">
            <h2 class="no-margin-bottom">Add Lokasi</h2>
          </div>
        </header>
        <section class="dashboard-header">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-body">

                    <form class="form-horizontal" action="create_place.php" method="post">
                      <div class="form-group row">
                        <label class="col-sm-2 form-control-label ">Nama Masjid</label>
                        <div class="col-sm-10">
                          <input class="form-control" type="text" name="<?= RequestKey::$PLACE_NAME ?>" value="" placeholder="Nama Lokasi">
                          <small class="form-text" >Nama masjid</small>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-2 form-control-label ">Lokasi Masjid</label>
                        <div class="col-sm-10">
                          <input class="form-control" type="text" name="<?= RequestKey::$PLACE_LOCATION ?>" value="" placeholder="Lokasi Masjid" required="nedd to fill">
                          <small class="form-text" >Lokasi Masjid</small>
                        </div>
                      </div>
                      <div class="form-group">
                        <a class="btn btn-secondary" href="index.php">Cancel</a>
                        <input class="btn btn-primary" type="submit" name="submit" value="Submit">
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
  <?php
  include('foot.php');
  echo '<script>var status = '.$status.';</script>';
  $status = 0;
  ?>
  <script>
  $(document).ready(function() {
    if (status == 1) {
      swal("Success!","Create Success","success")
      .then((value) => {
        window.location.href = "create_masjid.php";
        });
    }
    else if (status == 2) {
      swal("Failed!","Tidak bisa masuk query","error");
    }
    else if (status == 3) {
      swal("Failed!","Cek Inputan","error");
    }
  });
  </script>
</body>
</html>
