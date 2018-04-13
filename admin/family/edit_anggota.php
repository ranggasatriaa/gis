
<?php
session_start();
require_once('../../includes/request-key.php');
require_once('../../includes/db-helper.php');

if(!isset($_SESSION[RequestKey::$USER_ID])) {
  header('Location: ../../.');
}
else {
  $db = new DBHelper();

  $status          = 0;
  $message         = '';
  $err_location    = '';
  $err_name        = '';
  $err_status      = '';
  $err_religion    = '';
  $err_age         = '';
  $err_gender      = '';
  $err_born_place  = '';
  $err_born_date   = '';
  $err_education   = '';
  $err_salary      = '';
  $err_blood       = '';
  $err_sholat      = '';
  $err_mengaji     = '';


  if (isset($_GET[RequestKey::$FAMILY_ID])) {
    $fid      = $db->escapeInput($_GET[RequestKey::$FAMILY_ID]);
    $family   = $db->getFamilyById($fid);
    $keimanan = $db->getKeimananByFamilyId($fid);
  }elseif (isset($_POST[RequestKey::$FAMILY_ID])) {
    $fid      = $db->escapeInput($_POST[RequestKey::$FAMILY_ID]);
    $family   = $db->getFamilyById($fid);
    $keimanan = $db->getKeimananByFamilyId($fiid);
  }else {
    $status = 9;
    // header('Location: select_place.php');
  }
  // echo "string";
  if(isset($_POST[RequestKey::$FAMILY_ID])&& isset($_POST[RequestKey::$FAMILY_NAME])
  && isset($_POST[RequestKey::$FAMILY_STATUS]) && isset($_POST[RequestKey::$FAMILY_AGE])
  && isset($_POST[RequestKey::$FAMILY_RELIGION]) && isset($_POST[RequestKey::$FAMILY_GENDER])
  && isset($_POST[RequestKey::$FAMILY_BORN_PLACE]) && isset($_POST[RequestKey::$FAMILY_BORN_DATE])
  && isset($_POST[RequestKey::$FAMILY_SALARY])  && isset($_POST[RequestKey::$FAMILY_BLOOD])
  && isset($_POST[RequestKey::$KEIMANAN_SHOLAT]) && isset($_POST[RequestKey::$KEIMANAN_MENGAJI])){
    // echo "masuk if iset | ";
    $db = new DBHelper();

    //escapeInput
    $family_id          = $db->escapeInput($_POST[RequestKey::$FAMILY_ID]);
    $family_name        = $db->escapeInput($_POST[RequestKey::$FAMILY_NAME]);
    $family_status      = $db->escapeInput($_POST[RequestKey::$FAMILY_STATUS]);
    $family_age         = $db->escapeInput($_POST[RequestKey::$FAMILY_AGE]);
    $family_religion    = $db->escapeInput($_POST[RequestKey::$FAMILY_RELIGION]);
    $family_gender      = $db->escapeInput($_POST[RequestKey::$FAMILY_GENDER]);
    $family_born_place  = $db->escapeInput($_POST[RequestKey::$FAMILY_BORN_PLACE]);
    $family_born_date   = $db->escapeInput($_POST[RequestKey::$FAMILY_BORN_DATE]);
    $family_education   = $db->escapeInput($_POST[RequestKey::$FAMILY_EDUCATION]);
    $family_salary      = $db->escapeInput($_POST[RequestKey::$FAMILY_SALARY]);
    $family_blood       = $db->escapeInput($_POST[RequestKey::$FAMILY_BLOOD]);
    $keimanan_sholat    = $db->escapeInput($_POST[RequestKey::$KEIMANAN_MENGAJI]);
    $keimanan_mengaji   = $db->escapeInput($_POST[RequestKey::$KEIMANAN_SHOLAT]);

    //CEK ERROR PADA INPUTAN
    if(empty($err_name) && empty($err_gender) && empty($err_born_place) && empty($err_age)
    && empty($err_religion) && empty($err_born_date) && empty($err_education)
    && empty($err_salary) && empty($err_blood) && empty($err_sholat) && empty($err_mengaji)){
      // echo "masuk error | ";
      $array_family = array();
      $array_family[RequestKey::$FAMILY_ID]          = $family_id;
      $array_family[RequestKey::$FAMILY_NAME]        = $family_name;
      $array_family[RequestKey::$FAMILY_STATUS]      = $family_status;
      $array_family[RequestKey::$FAMILY_AGE]         = $family_age;
      $array_family[RequestKey::$FAMILY_RELIGION]    = $family_religion;
      $array_family[RequestKey::$FAMILY_GENDER]      = $family_gender;
      $array_family[RequestKey::$FAMILY_BORN_PLACE]  = $family_born_place;
      $array_family[RequestKey::$FAMILY_BORN_DATE]   = $family_born_date ;
      $array_family[RequestKey::$FAMILY_EDUCATION]   = $family_education;
      $array_family[RequestKey::$FAMILY_SALARY]      = $family_salary;
      $array_family[RequestKey::$FAMILY_BLOOD]       = $family_blood;
      $array_keimanan = array();
      $array_keimanan[RequestKey::$FAMILY_ID]  = $family_id;
      $array_keimanan[RequestKey::$KEIMANAN_SHOLAT]     = $keimanan_sholat;
      $array_keimanan[RequestKey::$KEIMANAN_MENGAJI]    = $keimanan_mengaji;

      // print_r($array_family);
      if ($db->editFamily($array_family) && $db->editKeimanan($array_keimanan)) {
        // echo "Masuk create keimanan |";
        $message = 'Sukses edit anggota';
        $status = 1;
      }
      else {
        $status = 2;
        $message = 'gagal edit';
      }
    }
    else{
      //telah ada lokasi yang sama
      $status = 2;
      $message = 'Cek Inputan';

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
            <h2 class="no-margin-bottom">Add family</h2>
          </div>
        </header>
        <section class="dashboard-header">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-body">

                    <form class="form-horizontal" action="edit_anggota.php?<?=RequestKey::$FAMILY_ID?>=<?=$fid?>" method="post">
                      <div class="form-group row">
                        <label class="col-sm-2 form-control-label ">Nama Lengkap</label>
                        <div class="col-sm-10">
                          <input class="form-control" type="text" name="<?= RequestKey::$FAMILY_NAME ?>" value="<?=$family->family_name?>" placeholder="Masukkan Nama Kepala keluarga">
                          <small class="form-text" ><?=$err_name?></small>
                        </div>
                      </div>
                      <div class="form-group row">
                        <?php if ($family->family_status == 0){ ?>
                          <input type="hidden" name="<?=RequestKey::$FAMILY_STATUS?>" value="0">
                        <?php }else{ ?>
                          <label class="col-sm-2 form-control-label ">Status di keluarga</label>
                          <div class="col-sm-10">
                            <select class="form-control" name="<?=RequestKey::$FAMILY_STATUS?>" required>
                              <option value=""> - Pilih -</option>
                              <option value="1" <?=$family->family_status == 1 ? "selected":""?> >Anak Pertama</option>
                              <option value="2" <?=$family->family_status == 2 ? "selected":""?> >Anggota keluarga</option>
                              <option value="3" <?=$family->family_status == 3 ? "selected":""?> >Pembantu</option>
                            </select>
                            <small class="form-text" ><?=$err_status?></small>
                          </div>
                        <?php } ?>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-2 form-control-label ">Jenis Kelamin</label>
                        <div class="col-sm-10">
                          <select class="form-control" name="<?=RequestKey::$FAMILY_GENDER?>" required>
                            <option value=""> - Pilih -</option>
                            <option value="1" <?=$family->family_gender == 1 ? "selected":""?> >Laki-laki</option>
                            <option value="2" <?=$family->family_gender == 2 ? "selected":""?> >Perempuan</option>
                          </select>
                          <small class="form-text" ><?=$err_gender?></small>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-2 form-control-label ">Agama</label>
                        <div class="col-sm-10">
                          <select class="form-control" name="<?=RequestKey::$FAMILY_RELIGION?>" required>
                            <option value=""> - Pilih-</option>
                            <option value="1" <?=$family->family_religion == 1 ? "selected":""?> >Islam</option>
                            <option value="2" <?=$family->family_religion == 2 ? "selected":""?> >Kristen</option>
                            <option value="3" <?=$family->family_religion == 3 ? "selected":""?> >Katolik</option>
                            <option value="4" <?=$family->family_religion == 4 ? "selected":""?> >Budha</option>
                            <option value="5" <?=$family->family_religion == 5 ? "selected":""?> >Hindu</option>
                          </select>
                          <small class="form-text" ><?=$err_gender?></small>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-2 form-control-label ">Tempat Lahir</label>
                        <div class="col-sm-10">
                          <input class="form-control" type="text" name="<?= RequestKey::$FAMILY_BORN_PLACE ?>" value="<?=$family->family_born_date?>" placeholder="Masukkan Tempat Lahir" required="">
                          <small class="form-text" ><?=$err_born_place?></small>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-2 form-control-label ">Tanggal Lahir</label>
                        <div class="col-sm-10">
                          <input class="form-control" type="date" name="<?= RequestKey::$FAMILY_BORN_DATE ?>" value="<?=$family->family_born_date?>" placeholder="" required="">
                          <small class="form-text" ><?=$err_born_date?></small>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-2 form-control-label ">Kategori Usia</label>
                        <div class="col-sm-10">
                          <select class="form-control" name="<?=RequestKey::$FAMILY_AGE?>" required>
                            <option value=""> - Pilih -</option>
                            <option value="1" <?=$family->family_age == 1 ? "selected":""?> >Balita</option>
                            <option value="2" <?=$family->family_age == 2 ? "selected":""?> >Anak-anak</option>
                            <option value="3" <?=$family->family_age == 3 ? "selected":""?> >Remaja</option>
                            <option value="4" <?=$family->family_age == 4 ? "selected":""?> >Dewasa</option>
                            <option value="5" <?=$family->family_age == 5 ? "selected":""?> >Lansia</option>
                          </select>
                          <small class="form-text" ><?=$err_gender?></small>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-2 form-control-label ">Pendidikan Terakhir</label>
                        <div class="col-sm-10">
                          <input class="form-control" type="text" name="<?= RequestKey::$FAMILY_EDUCATION ?>" value="<?=$family->family_education?>" placeholder="Masukkan Pendidikan Terakhir" required="">
                          <small class="form-text" ><?=$err_education?></small>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-2 form-control-label ">Penghasilan (dalam Rp)</label>
                        <div class="col-sm-10">
                          <input class="form-control" type="number" name="<?= RequestKey::$FAMILY_SALARY ?>" value="<?=$family->family_salary?>" placeholder="Masukkan Penghasilan">
                          <small class="form-text" ><?=$err_salary?></small>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-2 form-control-label ">Golongan Darah</label>
                        <div class="col-sm-10">
                          <select class="form-control" name="<?=RequestKey::$FAMILY_BLOOD?>">
                            <option value=""> - Pilih -</option>
                            <option value="1" <?=$family->family_blood == 1 ? "selected":""?> >A</option>
                            <option value="2" <?=$family->family_blood == 2 ? "selected":""?> >B</option>
                            <option value="3" <?=$family->family_blood == 3 ? "selected":""?> >AB</option>
                            <option value="4" <?=$family->family_blood == 4 ? "selected":""?> >O</option>
                          </select>
                          <small class="form-text" ><?=$err_blood?></small>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-2 form-control-label ">Kebiasaan Sholat</label>
                        <div class="col-sm-10">
                          <select class="form-control" name="<?=RequestKey::$KEIMANAN_SHOLAT?>">
                            <option value=""> - Pilih  -</option>
                            <option value="1" <?=$keimanan->keimanan_sholat == 1 ? "selected":""?> >5 waktu</option>
                            <option value="2" <?=$keimanan->keimanan_sholat == 2 ? "selected":""?> >tidak 5 waktu</option>
                            <option value="3" <?=$keimanan->keimanan_sholat == 3 ? "selected":""?> >Sholat jumat saja</option>
                            <option value="4" <?=$keimanan->keimanan_sholat == 4 ? "selected":""?> >Sholat Hari Raya saja</option>
                          </select>
                          <small class="form-text" ><?=$err_sholat?></small>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-2 form-control-label ">Kemampuan Mengaji</label>
                        <div class="col-sm-10">
                          <select class="form-control" name="<?=RequestKey::$KEIMANAN_MENGAJI?>">
                            <option value=""> - Pilih  -</option>
                            <option value="1" <?=$keimanan->keimanan_mengaji == 1 ? "selected":""?> >Tidak Bisa</option>
                            <option value="2" <?=$keimanan->keimanan_mengaji == 2 ? "selected":""?> >Kurang Lancar</option>
                            <option value="3" <?=$keimanan->keimanan_mengaji == 3 ? "selected":""?> >Lancar Membaca</option>
                            <option value="4" <?=$keimanan->keimanan_mengaji == 4 ? "selected":""?> >Hafal Al-Quran</option>
                          </select>
                          <small class="form-text" ><?=$err_mengaji?></small>
                        </div>
                      </div>
                      <div class="form-group">
                        <input type="hidden" name="<?=RequestKey::$FAMILY_ID?>" value="<?=$fid?>">
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
  echo '<script>var status = '.$status.'; var message = "'.$message.'"</script>';
  $status = 0;
  $message = '';
  ?>
  <script>
  $(document).ready(function() {
    if (status == 1) {
      swal("Success!",message,"success")
      .then((value) => {
        window.location.href = "detail_family.php?place-id=<?=$pid?>" + escape(window.location.href);
      });
    }
    else if (status == 2) {
      swal("Failed!",message,"error");
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
        window.location.href = "../place.php";
      });
    }
  });
  </script>
</body>
</html>
