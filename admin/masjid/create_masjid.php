
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
  $status       = 0;
  $err_name     = '';
  $err_location = '';
  $err_history  = '';

  if (isset($_POST[RequestKey::$PLACE_LOCATION])) {
    $location = $_POST[RequestKey::$PLACE_LOCATION];
  }else {
    $status = 9;
  }

  if(isset($_POST[RequestKey::$PLACE_NAME]) && isset($_POST[RequestKey::$PLACE_LOCATION]) && isset($_POST[RequestKey::$MASJID_HISTORY])){
    // echo "masuk if iset | ";
    $db = new DBHelper();

    //escapeInput
    $place_name     = $db->escapeInput($_POST[RequestKey::$PLACE_NAME]);
    $place_location = $db->escapeInput($_POST[RequestKey::$PLACE_LOCATION]);
    $place_category = 0;
    $masjid_name    = $db->escapeInput($_POST[RequestKey::$PLACE_NAME]);
    $masjid_history = $db->escapeInput($_POST[RequestKey::$MASJID_HISTORY]);

    //CEK ERROR PADA INPUTAN
    if(empty($err_name) && empty($err_location) && empty($err_history)){
      // echo "masuk error | ";
      $array_place = array();
      $array_place[RequestKey::$PLACE_NAME]     = $place_name;
      $array_place[RequestKey::$PLACE_LOCATION] = $place_location;
      $array_place[RequestKey::$PLACE_CATEGORY] = $place_category;
      // print_r($array_place);
      if (!$db->isLocationExist($place_location)) {
        if ($place = $db->createPlace($array_place)) {
          // echo "masuk create place | ";
          $masjid_place_id = (int)$db->lastPlaceId();
          // echo "place id: ". $masjid_place_id;
          $array_masjid = array();
          $array_masjid[RequestKey::$MASJID_NAME]    = $masjid_name;
          $array_masjid[RequestKey::$MASJID_PLACE_ID]       = $masjid_place_id;
          $array_masjid[RequestKey::$MASJID_HISTORY] = $masjid_history;
          // print_r($array_masjid);
          if ($masjid = $db->createMasjid($array_masjid)) {
            // echo "masuk masjid";
            $status = 1;
          }
          else{
            $db->deletePlace($masjid_place_id);
            $status = 2;
          }
        }
        else{
          //error create
          $status = 3;
        }
      }
      else{
        //telah ada lokasi yang sama
        $status = 4;
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
            <h2 class="no-margin-bottom">Add Masjid</h2>
          </div>
        </header>
        <section class="dashboard-header">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-body">

                    <form class="form-horizontal" action="create_masjid.php" method="post">
                      <div class="form-group row">
                        <label class="col-sm-2 form-control-label ">Lokasi Masjid</label>
                        <div class="col-sm-10">
                          <input class="form-control" type="text" disabled name="<?= RequestKey::$PLACE_LOCATION ?>" value="<?=$location?>">
                          <input class="form-control" type="hidden" name="<?= RequestKey::$PLACE_LOCATION ?>" value="<?=$location?>">
                          <small class="form-text" ></small>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-2 form-control-label ">Nama Masjid</label>
                        <div class="col-sm-10">
                          <input class="form-control" type="text" name="<?= RequestKey::$PLACE_NAME ?>" value="" placeholder="Nama Lokasi">
                          <small class="form-text" ><?=$err_name?></small>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-2 form-control-label ">Sejarah Masjid</label>
                        <div class="col-sm-10">
                          <textarea class="form-control"  name="<?= RequestKey::$MASJID_HISTORY ?>" rows="8" cols="80" placeholder="Sejarah Masjid"></textarea>
                          <small class="form-text" ><?=$err_history?></small>
                        </div>
                      </div>
                      <div class="form-group">
                        <a class="btn btn-secondary" href="../place.php">Cancel</a>
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
        window.location.href = "../place.php";
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
    else if (status == 9) {
      swal("Failed!","Tidak ada lokasi terpilih","error")
      .then((value) => {
        window.location.href = "select_place.php";
      });
    }
  });
  </script>
</body>
</html>
