
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
  //begin database
  $db = new DBHelper();
  $status = 0;
  $message = '';
  //cek if id exist
  if(isset($_GET[RequestKey::$MASJID_ID])){
    // echo "masuk if iset | ";
    //escapeInput
    $mid    = $db->escapeInput($_GET[RequestKey::$MASJID_ID]);
    $masjid = $db->getMasjidById($mid);
    $pid    = $masjid->place_id;
    //cek adanya kajian_id
    if ($db->isKajianExist($mid)) {
      //cek ada jumat
      if($db->isJumatExist($mid)){
        $del_kajian = $db->deleteKajianByMid($mid);
        $del_jumat  = $db->deleteJumatByMid($mid);
        $del_masjid = $db->deleteMasjid($mid);
        $del_place  = $db->deletePlace($pid);
        if ($del_kajian && $del_jumat && $del_masjid && $del_place) {
          $message  = 'Berhasil Menghapus!';
          $status   = 1;
        }
        else {
          $message  = 'Gagal Menghapus!';
          $status   = 2;
        }
      }
      //ada kajian tidak ada jumat
      else {
        $del_kajian = $db->deleteKajianByMid($mid);
        $del_masjid = $db->deleteMasjid($mid);
        $del_place  = $db->deletePlace($pid);
        if ($del_kajian && $del_masjid && $del_place) {
          $message  = 'Berhasil Menghapus!!';
          $status   = 1;
        }
        else {
          $message  = 'Gagal Menghapus!!';
          $status   = 2;
        }
      }
    }
    //tidak ada kajian
    else {
      //cek ada jumat
      if($db->isJumatExist($mid)){
        $del_jumat  = $db->deleteJumatByMid($mid);
        $del_masjid = $db->deleteMasjid($mid);
        $del_place  = $db->deletePlace($pid);
        if ($del_jumat && $del_masjid && $del_place) {
          $message  = 'Berhasil Menghapus!!!';
          $status   = 1;
        }
        else {
          $message  = 'Gagal Menghapus!!!';
          $status   = 2;
        }
      }
      //tidak ada kajian dan jumat
      else {
        $del_masjid = $db->deleteMasjid($mid);
        $del_place  = $db->deletePlace($pid);
        if ( $del_masjid && $del_place) {
          $message  = 'Berhasil Menghapus!!!!';
          $status   = 1;
        }
        else {
          $message  = 'Gagal Menghapus!!!!';
          $status   = 2;
        }
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
      <?php include('side-navbar.php') ?>

      <div class="content-inner">
        <!-- Page Header-->
        <header class="page-header">
          <div class="container-fluid">
            <h2 class="no-margin-bottom">Delete Masjid</h2>
          </div>
        </header>

        <?php include('page-footer.php'); ?>
      </div>
    </div>
  </div>
  <?php
  include('foot.php');
  echo '<script>var status = '.$status.'; var message ="'.$message.'"</script>';
  $status = 0;
  ?>
  <script>
  $(document).ready(function() {
    if (status == 1) {
      swal("Success!", message ,"success")
      .then((value) => {
        window.location.href = "../place.php";
      });
    }
    else if (status == 2) {
      swal("Failed!","Gagal Menghapus","error")
      .then((value) => {
        window.location.href = "../place.php";
      });
    }
  });
  </script>
</body>
</html>
