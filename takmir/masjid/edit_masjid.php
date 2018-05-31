
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
  $side_bar     = 2;
  
  //cek if id exist
  if(isset($_GET[RequestKey::$MASJID_ID])){
    $mid       = $db->escapeInput($_GET[RequestKey::$MASJID_ID]);
    $masjid    = $db->getMasjidById($mid);
  }
  else if(isset($_POST[RequestKey::$MASJID_ID])){
    $mid       = $db->escapeInput($_POST[RequestKey::$MASJID_ID]);
    $masjid    = $db->getMasjidById($mid);
  }
  else{
    header('location: ../place.php');
  }

  //standart variabel
  $status       = 0;
  $err_name     = '';
  $err_history  = '';
  $place_id     = $masjid->place_id;
// echo "string";
  if(isset($_POST[RequestKey::$MASJID_ID]) && isset($_POST[RequestKey::$MASJID_NAME]) && isset($_POST[RequestKey::$MASJID_HISTORY])){
    // echo "masuk if iset | ";
    //escapeInput
    $masjid_id      = $db->escapeInput($_POST[RequestKey::$MASJID_ID]);
    $masjid_name    = $db->escapeInput($_POST[RequestKey::$MASJID_NAME]);
    $masjid_history = $db->escapeInput($_POST[RequestKey::$MASJID_HISTORY]);

    //CEK ERROR PADA INPUTAN
    if(empty($err_name) && empty($err_history)){
      // echo "masuk error | ";
      $array = array();
      $array[RequestKey::$MASJID_ID]       = $masjid_id;
      $array[RequestKey::$MASJID_NAME]     = $masjid_name;
      $array[RequestKey::$MASJID_HISTORY]  = $masjid_history;
      // print_r($array_place);
      if ($masjid = $db->editMasjid($array)) {
        // echo "masuk create place | ";
        $status = 1;
      }
      else{
        $status = 2;
      }
    }
    else{
      //error create
      $status = 3;
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
            <h2 class="no-margin-bottom">Add Masjid</h2>
          </div>
        </header>
        <section class="dashboard-header">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-body">

                    <form class="form-horizontal" action="edit_masjid.php?masjid-id=<?=$mid?>" method="post">
                      <div class="form-group row">
                        <label class="col-sm-2 form-control-label ">Nama Masjid</label>
                        <div class="col-sm-10">
                          <input class="form-control" type="text" name="<?= RequestKey::$MASJID_NAME ?>" value="<?=$masjid->masjid_name?>" placeholder="Nama Lokasi">
                          <small class="form-text" ><?=$err_name;?></small>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-2 form-control-label ">Sejarah Masjid</label>
                        <div class="col-sm-10">
                          <textarea class="form-control"  name="<?= RequestKey::$MASJID_HISTORY ?>" rows="8" cols="80" placeholder="Sejarah Masjid"><?=$masjid->masjid_history?></textarea>
                          <small class="form-text" ><?=$err_history?></small>
                        </div>
                      </div>
                      <div class="form-group">
                        <input type="hidden" name="<?=RequestKey::$MASJID_ID?>" value="<?=$mid?>">
                        <a class="btn btn-secondary" href="detail_masjid.php?place-id=<?=$place_id?>">Cancel</a>
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
        window.location.href = "detail_masjid.php?place-id=<?=$place_id?>" + escape(window.location.href);
      });
    }
    else if (status == 2) {
      swal("Failed!","Tidak bisa masuk query","error");
    }
    else if (status == 3) {
      swal("Failed!","Cek Inputan","error");
    }
    else if (status == 4) {
      swal("Failed!","Same location","error");
    }
  });
  </script>
</body>
</html>
