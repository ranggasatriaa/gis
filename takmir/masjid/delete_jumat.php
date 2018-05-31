
<?php
session_start();
require_once('../../includes/request-key.php');
require_once('../../includes/db-helper.php');

if(!isset($_SESSION[RequestKey::$USER_ID])) {
  header('Location: ../../.');
}
if ($_SESSION[RequestKey::$USER_LEVEL] != 1){
  header('Location: ../../unauthorize.php');
}
else {
  $db = new DBHelper();
  if(isset($_GET[RequestKey::$JUMAT_ID])){
    $jid        = $db->escapeInput($_GET[RequestKey::$JUMAT_ID]);
    $jumat      =  $db->getJumatById($jid);
    $masjid     = $db->getMasjidById($jumat->masjid_id);
    $place_id   = $masjid->place_id;

    if ($result = $db->deleteJumat($jid)) {
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
      <?php include('side-navbar.php') ?>

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
        window.location.href = "detail_masjid.php?place-id=<?=$place_id?>" + escape(window.location.href);
      });
    }
    else if (status == 2) {
      swal("Failed!","Tidak bisa masuk query","error");
      window.location.href = "detail_masjid.php?place-id=<?=$place_id ?>" + escape(window.location.href);
    }
    else if (status == 3) {
      swal("Failed!","Id Kajian tidak ditemukan","error");
      window.location.href = ".";

    }
  });
  </script>
</body>
</html>
