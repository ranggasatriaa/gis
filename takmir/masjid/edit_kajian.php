
<?php
session_start();
require_once('../../includes/request-key.php');
require_once('../../includes/db-helper.php');

if(!isset($_SESSION[RequestKey::$USER_ID])) {
  header('Location: ../../.');
}
else {
  $db               = new DBHelper();

  if (isset($_GET[RequestKey::$KAJIAN_ID])) {
    $kid          = $db->escapeInput($_GET[RequestKey::$KAJIAN_ID]);
  }elseif(isset($_POST[RequestKey::$JUMAT_ID])){
    $kid          = $db->escapeInput($_POST[RequestKey::$KAJIAN_ID]);
  }else {
    header('location: ../place.php ');
  }
  $kajian           = $db->getKajianById($kid);
  $masjid           = $db->getMasjidById($kajian->masjid_id);
  $place_id         = $masjid->place_id;


  $status           = 0;
  $err_date         = '';
  $err_time         = '';
  $err_title        = '';
  $err_description  = '';
  $err_speaker      = '';


  if(isset($_POST[RequestKey::$KAJIAN_ID]) && isset($_POST[RequestKey::$KAJIAN_DATE]) && isset($_POST[RequestKey::$KAJIAN_TIME]) && isset($_POST[RequestKey::$KAJIAN_TITLE]) && isset($_POST[RequestKey::$KAJIAN_DESCRIPTION]) && isset($_POST[RequestKey::$KAJIAN_SPEAKER])){
    //escapeInput
    $kajian_id           = $db->escapeInput($_POST[RequestKey::$KAJIAN_ID]);
    $kajian_date         = $db->escapeInput($_POST[RequestKey::$KAJIAN_DATE]);
    $kajian_time         = $db->escapeInput($_POST[RequestKey::$KAJIAN_TIME]);
    $kajian_title        = $db->escapeInput($_POST[RequestKey::$KAJIAN_TITLE]);
    $kajian_description  = $db->escapeInput($_POST[RequestKey::$KAJIAN_DESCRIPTION]);
    $kajian_speaker      = $db->escapeInput($_POST[RequestKey::$KAJIAN_SPEAKER]);

    //CEK ERROR PADA INPUTAN
    if(empty($err_date) && empty($err_time) && empty($err_title) && empty($err_description) && empty($err_speaker)){
      $array = array();
      $array[RequestKey::$KAJIAN_ID]              = $kajian_id;
      $array[RequestKey::$KAJIAN_DATE]            = $kajian_date;
      $array[RequestKey::$KAJIAN_TIME]            = $kajian_time;
      $array[RequestKey::$KAJIAN_TITLE]           = $kajian_title;
      $array[RequestKey::$KAJIAN_DESCRIPTION]     = $kajian_description;
      $array[RequestKey::$KAJIAN_SPEAKER]         = $kajian_speaker;
      // print_r($array);
      if ($kajians = $db->editKajian($array)) {
        $status = 1;
      }
      else{
        //error create
        $status = 2;
      }
    }
    else{
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
      <nav class="side-navbar">
        <!-- Sidebar Header-->
        <div class="sidebar-header d-flex align-items-center">
          <div class="avatar"><img src="../../img/no_image_image.png" alt="..." class="img-fluid rounded-circle" style="height:55px; width: 55px; object-fit: contain;"></div>
          <div class="title">
            <h1 class="h4">ADMIN</h1>
          </div>
        </div>
        <!-- Sidebar Navidation Menus--><span class="heading">Main</span>
        <ul class="list-unstyled">
          <li><a href="../."> <i class="icon-home"></i>Dashboard </a></li>
          <li class="active"><a href="../place.php"> <i class="fa fa-map-o"></i>Place </a></li>
          <li><a href="../profil.php"> <i class="icon-user"></i>Profil </a></li>
        </ul>
      </nav>
      <div class="content-inner">
        <!-- Page Header-->
        <header class="page-header">
          <div class="container-fluid">
            <h2 class="no-margin-bottom">Edit Kajian</h2>
          </div>
        </header>
        <section class="dashboard-header">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-body">
                    <form class="form-horizontal" action="edit_kajian.php?kajian-id=<?=$kid?>" method="post">
                      <div class="form-group row">
                        <label class="col-sm-2 form-control-label ">Tanggal Kajian</label>
                        <div class="col-sm-10">
                          <input class="form-control" type="date" name="<?= RequestKey::$KAJIAN_DATE ?>" value="<?=$kajian->kajian_date?>" placeholder="Tanggal Kajian">
                          <small class="form-text" ><?=$err_date?></small>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-2 form-control-label ">Waktu Kajian</label>
                        <div class="col-sm-10">
                          <input class="form-control" type="time" name="<?= RequestKey::$KAJIAN_TIME ?>" value="<?=$kajian->kajian_time?>" placeholder="Waktu Kajian">
                          <small class="form-text" ><?=$err_time?></small>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-2 form-control-label ">Judul Kajian</label>
                        <div class="col-sm-10">
                          <input class="form-control" type="text" name="<?= RequestKey::$KAJIAN_TITLE ?>" value="<?=$kajian->kajian_title?>" placeholder="Judual Kajian">
                          <small class="form-text" ><?=$err_title?></small>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-2 form-control-label ">Deskripsi Kajian</label>
                        <div class="col-sm-10">
                          <textarea name="<?=RequestKey::$KAJIAN_DESCRIPTION?>" rows="5" cols="80"><?=$kajian->kajian_description?></textarea>
                          <small class="form-text" ><?=$err_description?></small>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-2 form-control-label ">Pengisi Kajian</label>
                        <div class="col-sm-10">
                          <input class="form-control" type="text" name="<?= RequestKey::$KAJIAN_SPEAKER; ?>" value="<?=$kajian->kajian_speaker?>" placeholder="Judual Kajian">
                          <small class="form-text" ><?=$err_speaker?></small>
                        </div>
                      </div>
                      <div class="form-group">
                        <input type="hidden" name="<?=RequestKey::$KAJIAN_ID?>" value="<?=$kid?>">
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
      swal("Success!","Delete Success","success")
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
