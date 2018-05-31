
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
  $status           = 0;
  $err_date         = '';
  $err_time         = '';
  $err_title        = '';
  $err_description  = '';
  $err_speaker      = '';

  if(isset($_GET[RequestKey::$MASJID_ID])){
    $mid = $db->escapeInput($_GET[RequestKey::$MASJID_ID]);
    $masjid = $db->getMasjidById($mid);
    $place_id = $masjid->place_id;
  }else {
    header('location: ../place.php ');
  }

  if(isset($_POST[RequestKey::$KAJIAN_MASJID_ID]) && isset($_POST[RequestKey::$KAJIAN_DATE]) && isset($_POST[RequestKey::$KAJIAN_TIME]) && isset($_POST[RequestKey::$KAJIAN_TITLE]) && isset($_POST[RequestKey::$KAJIAN_DESCRIPTION]) && isset($_POST[RequestKey::$KAJIAN_SPEAKER])){
    // echo date('Y-m-d', strtotime($_POST[RequestKey::$KAJIAN_DATE]));
    //escapeInput
    // $masjid_id           = $db->escapeInput($_POST([RequestKey::$KAJIAN_MASJID_ID]));
    $masjid_id           = $db->escapeInput($_POST[RequestKey::$KAJIAN_MASJID_ID]);
    $kajian_date         = $db->escapeInput($_POST[RequestKey::$KAJIAN_DATE]);
    $kajian_time         = $db->escapeInput($_POST[RequestKey::$KAJIAN_TIME]);
    $kajian_title        = $db->escapeInput($_POST[RequestKey::$KAJIAN_TITLE]);
    $kajian_description  = $db->escapeInput($_POST[RequestKey::$KAJIAN_DESCRIPTION]);
    $kajian_speaker      = $db->escapeInput($_POST[RequestKey::$KAJIAN_SPEAKER]);

    //CEK ERROR PADA INPUTAN
    if(empty($err_date) && empty($err_time) && empty($err_title) && empty($err_description) && empty($err_speaker)){
      $array = array();
      $array[RequestKey::$KAJIAN_MASJID_ID]       = $masjid_id;
      $array[RequestKey::$KAJIAN_DATE]            = $kajian_date;
      $array[RequestKey::$KAJIAN_TIME]            = $kajian_time;
      $array[RequestKey::$KAJIAN_TITLE]           = $kajian_title;
      $array[RequestKey::$KAJIAN_DESCRIPTION]     = $kajian_description;
      $array[RequestKey::$KAJIAN_SPEAKER]         = $kajian_speaker;
      // print_r($array);
      if ($kajian = $db->createKajian($array)) {
        // echo "masuk create kajian | ";
        $status = 1;
      }
      else{
        //error create
        $status = 2;
      }
    }
    else {
      //salah inputan
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
            <h2 class="no-margin-bottom">Add Kajian</h2>
          </div>
        </header>
        <section class="dashboard-header">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-body">
                    <form class="form-horizontal" action="create_kajian.php?masjid-id=<?=$mid?>" method="post">
                      <div class="form-group row">
                        <label class="col-sm-2 form-control-label ">Tanggal Kajian</label>
                        <div class="col-sm-10">
                          <input class="form-control" type="date" name="<?= RequestKey::$KAJIAN_DATE ?>" value="" placeholder="Tanggal Kajian">
                          <small class="form-text" ><?=$err_date?></small>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-2 form-control-label ">Waktu Kajian</label>
                        <div class="col-sm-10">
                          <input class="form-control" type="time" name="<?= RequestKey::$KAJIAN_TIME ?>" value="" placeholder="Waktu Kajian">
                          <small class="form-text" ><?=$err_time?></small>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-2 form-control-label ">Judul Kajian</label>
                        <div class="col-sm-10">
                          <input class="form-control" type="text" name="<?= RequestKey::$KAJIAN_TITLE ?>" value="" placeholder="Judual Kajian">
                          <small class="form-text" ><?=$err_title?></small>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-2 form-control-label ">Deskripsi Kajian</label>
                        <div class="col-sm-10">
                          <textarea name="<?=RequestKey::$KAJIAN_DESCRIPTION?>" rows="5" cols="80"></textarea>
                          <small class="form-text" ><?=$err_description?></small>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-2 form-control-label ">Pengisi Kajian</label>
                        <div class="col-sm-10">
                          <input class="form-control" type="text" name="<?= RequestKey::$KAJIAN_SPEAKER ?>" value="" placeholder="Pengisi Kajian">
                          <small class="form-text" ><?=$err_speaker?></small>
                        </div>
                      </div>
                      <div class="form-group">
                        <input type="hidden" name="<?=RequestKey::$KAJIAN_MASJID_ID?>" value="<?=$mid?>">
                        <a class="btn btn-secondary" href="detail_masjid.php?<?=RequestKey::$PLACE_ID?>=<?=$place_id?>">Cancel</a>
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
  echo '<script>var status = '.$status.'</script>';
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
  });
  </script>
</body>
</html>
