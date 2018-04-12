
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
  $err_name        = '';
  $err_status      = '';
  $err_religion    = '';
  $err_gender      = '';
  $err_born_place  = '';
  $err_born_date   = '';
  $err_education   = '';
  $err_salary      = '';
  $err_blood       = '';
  $db = new DBHelper();

  if(isset($_GET[RequestKey::$FAMILY_ID])){
    $fid = $db->escapeInput($_GET[RequestKey::$FAMILY_ID]);
    $family_old = $db->getFamilyById($fid);
    $pid = $family_old->place_id;
    // $place_id = $masjid->place_id;
  }else {
    header('location: ../place.php ');
  }

  if(isset($_POST[RequestKey::$FAMILY_ID]) && isset($_POST[RequestKey::$FAMILY_NAME])
  && isset($_POST[RequestKey::$FAMILY_STATUS]) && isset($_POST[RequestKey::$FAMILY_RELIGION]) && isset($_POST[RequestKey::$FAMILY_GENDER])
  // echo "masuk if iset | ";
  && isset($_POST[RequestKey::$FAMILY_BORN_PLACE]) && isset($_POST[RequestKey::$FAMILY_BORN_DATE])
  && isset($_POST[RequestKey::$FAMILY_SALARY])  && isset($_POST[RequestKey::$FAMILY_BLOOD])){

    //escapeInput
    $family_id          = $db->escapeInput($_POST[RequestKey::$FAMILY_ID]);
    $family_name        = $db->escapeInput($_POST[RequestKey::$FAMILY_NAME]);
    $family_status      = $db->escapeInput($_POST[RequestKey::$FAMILY_STATUS]);
    $family_religion    = $db->escapeInput($_POST[RequestKey::$FAMILY_RELIGION]);
    $family_gender      = $db->escapeInput($_POST[RequestKey::$FAMILY_GENDER]);
    $family_born_place  = $db->escapeInput($_POST[RequestKey::$FAMILY_BORN_PLACE]);
    $family_born_date   = $db->escapeInput($_POST[RequestKey::$FAMILY_BORN_DATE]);
    $family_education   = $db->escapeInput($_POST[RequestKey::$FAMILY_EDUCATION]);
    $family_salary      = $db->escapeInput($_POST[RequestKey::$FAMILY_SALARY]);
    $family_blood       = $db->escapeInput($_POST[RequestKey::$FAMILY_BLOOD]);

    //CEK ERROR PADA INPUTAN
    if(empty($err_name) && empty($err_gender) && empty($err_born_place)
    && empty($err_born_date) && empty($err_education) && empty($err_salary)
    && empty($err_blood)){
      // echo "masuk error | ";

      $family_age =  date_diff(date_create($family_born_date), date_create('today'))->y;
      // echo "place id: ". $family_place_id;
      $array_family = array();
      $array_family[RequestKey::$FAMILY_ID]          = $family_id;
      $array_family[RequestKey::$FAMILY_NAME]        = $family_name;
      $array_family[RequestKey::$FAMILY_STATUS]      = $family_status;
      $array_family[RequestKey::$FAMILY_RELIGION]    = $family_religion;
      $array_family[RequestKey::$FAMILY_GENDER]      = $family_gender;
      $array_family[RequestKey::$FAMILY_BORN_PLACE]  = $family_born_place;
      $array_family[RequestKey::$FAMILY_BORN_DATE]   = $family_born_date ;
      $array_family[RequestKey::$FAMILY_EDUCATION]   = $family_education;
      $array_family[RequestKey::$FAMILY_SALARY]      = $family_salary;
      $array_family[RequestKey::$FAMILY_BLOOD]       = $family_blood;

      // print_r($array_family);
      if ($family = $db->editFamily($array_family)) {
        // echo "edit family";
        $status = 1;
        // $message = "Berhasil menambah anggota";
      }
      else{
        //error create
        $status = 2;
        // $message = 'Gagal Masuk query';
      }
    }
    else{
      //salah inputan
      $status = 3;
      // $message = "Cek Inputan";
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
          <li class="active"><a href="../../place.php"> <i class="fa fa-map-o"></i>Place </a></li>
          <li><a href="../profil.php"> <i class="icon-user"></i>Profil </a></li>
        </ul>
      </nav>
      <div class="content-inner">
        <!-- Page Header-->
        <header class="page-header">
          <div class="container-fluid">
            <h2 class="no-margin-bottom">Add family</h2>
          </div>
        </header>
        <section class="dashboard-header">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-body">

                    <form class="form-horizontal" action="edit_anggota.php?family-id=<?=$fid?>" method="post">
                      <div class="form-group row">
                        <label class="col-sm-2 form-control-label ">Nama Lengkap</label>
                        <div class="col-sm-10">
                          <input class="form-control" type="text" name="<?= RequestKey::$FAMILY_NAME ?>" value="<?=$family_old->family_name?>" placeholder="Nama Lengkap">
                          <small class="form-text" ><?=$err_name?></small>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-2 form-control-label ">Status di keluarga</label>
                        <div class="col-sm-10">
                          <select class="form-control" name="<?=RequestKey::$FAMILY_STATUS?>" required>
                            <option value=""> - Pilih -</option>
                            <option value="0" <?=$family_old->family_status == 0 ? "selected":""?> >Kepala Keluarga</option>
                            <option value="1" <?=$family_old->family_status == 1 ? "selected":""?> >Anak Pertama</option>
                            <option value="2" <?=$family_old->family_status == 2 ? "selected":""?> >Anggota keluarga</option>
                            <option value="3" <?=$family_old->family_status == 3 ? "selected":""?> >Pembantu</option>
                          </select>
                          <small class="form-text" ><?=$err_status?></small>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-2 form-control-label ">Jenis Kelamin</label>
                        <div class="col-sm-10">
                          <select class="form-control" name="<?=RequestKey::$FAMILY_GENDER?>" required>
                            <option value=""> - Pilih -</option>
                            <option value="1" <?=$family_old->family_gender == 1 ? "selected":""?> >Laki-laki</option>
                            <option value="2" <?=$family_old->family_gender == 2 ? "selected":""?> >Perempuan</option>
                          </select>
                          <small class="form-text" ><?=$err_gender?></small>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-2 form-control-label ">Agama</label>
                        <div class="col-sm-10">
                          <select class="form-control" name="<?=RequestKey::$FAMILY_RELIGION?>" required>
                            <option value=""> - Pilih Agama -</option>
                            <option value="1" <?=$family_old->family_religion == 1 ? "selected":""?>>Islam</option>
                            <option value="2" <?=$family_old->family_religion == 2 ? "selected":""?>>Kristen</option>
                            <option value="3" <?=$family_old->family_religion == 3 ? "selected":""?>>Katolik</option>
                            <option value="4" <?=$family_old->family_religion == 4 ? "selected":""?>>Budha</option>
                            <option value="5" <?=$family_old->family_religion == 5 ? "selected":""?>>Hindu</option>
                          </select>
                          <small class="form-text" ><?=$err_gender?></small>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-2 form-control-label ">Tempat Lahir</label>
                        <div class="col-sm-10">
                          <input class="form-control" type="text" name="<?= RequestKey::$FAMILY_BORN_PLACE ?>" value="<?=$family_old->family_born_place?>" placeholder="Tempat lahir" required="">
                          <small class="form-text" ><?=$err_born_place?></small>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-2 form-control-label ">Tanggal Lahir</label>
                        <div class="col-sm-10">
                          <input class="form-control" type="date" name="<?= RequestKey::$FAMILY_BORN_DATE ?>" value="<?=$family_old->family_born_date?>" placeholder="Tanggal lahir" required="">
                          <small class="form-text" ><?=$err_born_date?></small>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-2 form-control-label ">Pendidikan Terakhir</label>
                        <div class="col-sm-10">
                          <input class="form-control" type="text" name="<?= RequestKey::$FAMILY_EDUCATION ?>" value="<?=$family_old->family_education?>" placeholder="Pendidikan Terakhir" required="">
                          <small class="form-text" ><?=$err_education?></small>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-2 form-control-label ">Penghasilan (dalam Rp)</label>
                        <div class="col-sm-10">
                          <input class="form-control" type="number" name="<?= RequestKey::$FAMILY_SALARY ?>" value="<?=$family_old->family_salary?>" placeholder="Pendapatan">
                          <small class="form-text" ><?=$err_salary?></small>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-2 form-control-label ">Golongan Darah</label>
                        <div class="col-sm-10">
                          <select class="form-control" name="<?=RequestKey::$FAMILY_BLOOD?>">
                            <option value=""> - Pilih -</option>
                            <option value="A" <?=$family_old->family_blood == "A" ? "selected":""?> >A</option>
                            <option value="B" <?=$family_old->family_blood == "B" ? "selected":""?> >B</option>
                            <option value="AB" <?=$family_old->family_blood == "AB" ? "selected":""?> >AB</option>
                            <option value="O" <?=$family_old->family_blood == "O" ? "selected":""?> >O</option>

                          </select>
                          <small class="form-text" ><?=$err_blood?></small>
                        </div>
                      </div>

                      <div class="form-group">
                        <input type="hidden" name="<?=RequestKey::$FAMILY_ID?>" value="<?=$fid?>">
                        <a class="btn btn-secondary" href="detail_family.php?place-id=<?=$pid?>">Cancel</a>
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
      swal("Success!","Berhasil megubah anggota","success")
      .then((value) => {
        window.location.href = "detail_family.php?place-id=<?=$pid?>" + escape(window.location.href);
      })
    }
    else if (status == 2) {
      swal("Failed!","gagal query","error");
    }
    else if (status == 3) {
      swal("Failed!","Cek inputan","error");
    }
  });
  </script>
</body>
</html>
