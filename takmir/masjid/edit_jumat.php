
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
  $db           = new DBHelper();
  $side_bar     = 2;
  

  if (isset($_GET[RequestKey::$JUMAT_ID])) {
    $jid          = $db->escapeInput($_GET[RequestKey::$JUMAT_ID]);
  }elseif(isset($_POST[RequestKey::$JUMAT_ID])){
    $jid          = $db->escapeInput($_POST[RequestKey::$JUMAT_ID]);
  }else {
    header('location: place.php ');
  }

  $jumat        = $db->getJumatById($jid);
  $masjid       = $db->getMasjidById($jumat->masjid_id);
  $place_id     = $masjid->place_id;

  $status       = 0;
  $err_date     = '';
  $err_imam     = '';


  if(isset($_POST[RequestKey::$JUMAT_ID]) && isset($_POST[RequestKey::$JUMAT_DATE]) && isset($_POST[RequestKey::$JUMAT_IMAM])){
    //escapeInput
    $jumat_id           = $db->escapeInput($_POST[RequestKey::$JUMAT_ID]);
    $jumat_date         = $db->escapeInput($_POST[RequestKey::$JUMAT_DATE]);
    $jumat_imam         = $db->escapeInput($_POST[RequestKey::$JUMAT_IMAM]);

    //CEK ERROR PADA INPUTAN
    if(empty($err_date) && empty($err_imam)){
      $array = array();
      $array[RequestKey::$JUMAT_ID]        = $jumat_id;
      $array[RequestKey::$JUMAT_DATE]      = $jumat_date;
      $array[RequestKey::$JUMAT_IMAM]      = $jumat_imam;
      // print_r($array);
      if ($jumat = $db->editJumat($array)) {
        $status = 1;
      }
      else{
        //error create
        $status = 2;
      }
    }
    else{
      //salah INPUTAN
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
            <h2 class="no-margin-bottom">Add jumat</h2>
          </div>
        </header>
        <section class="dashboard-header">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-body">
                    <form class="form-horizontal" action="edit_jumat.php?jumat-id=<?=$jid?>" method="post">
                      <div class="form-group row">
                        <label class="col-sm-2 form-control-label ">Tanggal Jumat</label>
                        <div class="col-sm-10">
                          <input class="form-control" type="date" name="<?= RequestKey::$JUMAT_DATE ?>" value="<?=$jumat->jumat_date?>" placeholder="Tanggal jumat">
                          <small class="form-text" ><?=$err_date?></small>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-2 form-control-label ">Imam jumat</label>
                        <div class="col-sm-10">
                          <input class="form-control" type="text" name="<?= RequestKey::$JUMAT_IMAM ?>" value="<?=$jumat->jumat_imam?>" placeholder="Imam jumat">
                          <small class="form-text" ><?=$err_imam?></small>
                        </div>
                      </div>
                      <div class="form-group">
                        <input type="hidden" name="<?=RequestKey::$JUMAT_ID?>" value="<?=$jid?>">
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
      swal("Success!","Edit Success","success")
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
