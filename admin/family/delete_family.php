
<?php
session_start();
require_once('../../includes/request-key.php');
require_once('../../includes/db-helper.php');

if(!isset($_SESSION[RequestKey::$USER_ID])) {
  header('Location: ../../.');
}if ($_SESSION[RequestKey::$USER_LEVEL] != 0){
  header('Location: ../../unauthorize.php');
}
else {

  $status          = 0;
  $message         = '';

  $db = new DBHelper();

  if(isset($_GET[RequestKey::$PLACE_ID])){
    $pid = $db->escapeInput($_GET[RequestKey::$PLACE_ID]);
    if ($db->deleteFamilyByPlaceId($pid)) {
      if($db->deleteplace($pid)){

        $status = 1;
      }
      else {
        $status = 2;
      }
    }
    else {
      //GAGAL QUERY
      $status = 2;
    }
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
      <?php include('side-navbar.php') ?>

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
      swal("Success!","Berhasil menghapus keluarga","success")
      .then((value) => {
        window.location.href = "../place.php";
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
