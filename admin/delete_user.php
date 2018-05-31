
<?php
session_start();
require_once('../includes/request-key.php');
require_once('../includes/db-helper.php');

if(!isset($_SESSION[RequestKey::$USER_ID])) {
  header('Location: ../.');
}
if ($_SESSION[RequestKey::$USER_LEVEL] != 0){
  header('Location: ../unauthorize.php');
}
else {
  //begin database
  $side_bar = 3;
  $db = new DBHelper();
  $status = 0;
  $message = '';
  //cek if id exist
  if(isset($_GET[RequestKey::$USER_ID])){
    // echo "masuk if iset | ";
    //escapeInput
    $uid    = $db->escapeInput($_GET[RequestKey::$USER_ID]);
    // $masjid = $db->getMasjidById($mid);
    // $pid    = $masjid->place_id;
    //cek adanya kajian_id
    if ($db->deleteUser($uid)) {
      $status = 1;
      $message = 'Berhasil dihapus';
    }
    else {
      $status = 2;
      $message = 'Gagal query';
    }
  }
  else {
    $status = 2;
    $message = 'Id tidak ditemukan';
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

      </nav>
      <div class="content-inner">
        <!-- Page Header-->
        <header class="page-header">
          <div class="container-fluid">
            <h2 class="no-margin-bottom">Delete User</h2>
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
        window.location.href = "user.php";
      });
    }
    else if (status == 2) {
      swal("Failed!",message,"error")
      .then((value) => {
        window.location.href = "user.php";
      });
    }
  });
  </script>
</body>
</html>
