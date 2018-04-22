
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
    $fid    = $db->escapeInput($_GET[RequestKey::$FAMILY_ID]);
    $family = $db->getFamilyById($fid);
    $pid    = $family->place_id;
    echo $fid;

    if ($family->family_status == 0) {
      if ($result = $db->dieFamily($fid)) {
        if ($istris   = $db->getFamilyIstri($pid)) {
          echo "1 ";
          while ($istri = $istris->fetch_object()) {
            echo "2 ";
            echo " - ".$istri->family_id;
            $db->updateIstri($istri->family_id);
          }
        }
        $status = 1;
        $message = 'Anggota keluarga telah meninggal :"(()';
      }else {
        if ($result = $db->dieFamily($fid)) {
          //MASUK DELETE
          $status = 1;
          $message = 'Anggota keluarga telah meninggal :"(';
        }
        else {
          //GAGAL QUERY
          $status = 2;
          $message = 'Anggota keluarga gagal meinggal :)';

        }
      }
    }else {
      if ($result = $db->dieFamily($fid)) {
        //MASUK DELETE
        $status = 1;
        $message = 'Anggota keluarga telah meninggal :"(';
      }
      else {
        //GAGAL QUERY
        $status = 2;
        $message = 'Anggota keluarga gagal meinggal :)';

      }
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
  echo '<script>var status = '.$status.'; </script>';
  $status = 0;
  // $message = '';
  ?>
  <script>
  $(document).ready(function() {
    if (status == 1) {
      swal("Success!","message","success")
      .then((value) => {
        window.location.href = "detail_family.php?place-id=<?=$pid?>" + escape(window.location.href);
      })
    }
    else if (status == 2) {
      swal("Failed!",message,"error");
    }
  });
  </script>
</body>
</html>
