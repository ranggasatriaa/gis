
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

  $db = new DBHelper();

  if(isset($_GET[RequestKey::$FAMILY_ID])){
    $fid = $db->escapeInput($_GET[RequestKey::$FAMILY_ID]);
    $family_old = $db->getFamilyById($fid);
    $pid = $family_old->place_id;
    if ($result = $db->deleteFamilyById($fid)) {
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
      swal("Success!","Berhasil menghapus anggota","success")
      .then((value) => {
        window.location.href = "detail_family.php?place-id=<?=$pid?>" + escape(window.location.href);
      })
    }
    else if (status == 2) {
      swal("Failed!","gagal query","error");
    }
  });
  </script>
</body>
</html>
