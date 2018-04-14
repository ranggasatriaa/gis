
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
  $err_mengaji       = '';


  if (isset($_POST[RequestKey::$PLACE_LOCATION])) {
    $location = $_POST[RequestKey::$PLACE_LOCATION];
  }else {
    $status = 9;
    // header('Location: select_place.php');
  }
  // echo "string";
  if(isset($_POST[RequestKey::$PLACE_LOCATION]) &&isset($_POST[RequestKey::$FAMILY_NAME])
  && isset($_POST[RequestKey::$FAMILY_STATUS]) && isset($_POST[RequestKey::$FAMILY_AGE])
  && isset($_POST[RequestKey::$FAMILY_RELIGION]) && isset($_POST[RequestKey::$FAMILY_GENDER])
  && isset($_POST[RequestKey::$FAMILY_BORN_PLACE]) && isset($_POST[RequestKey::$FAMILY_BORN_DATE])
  && isset($_POST[RequestKey::$FAMILY_SALARY])  && isset($_POST[RequestKey::$FAMILY_BLOOD])
  && isset($_POST[RequestKey::$KEIMANAN_SHOLAT]) && isset($_POST[RequestKey::$KEIMANAN_MENGAJI])){
    // echo "masuk if iset | ";
    $db = new DBHelper();

    //escapeInput
    $place_name         = $db->escapeInput($_POST[RequestKey::$FAMILY_NAME]);
    $place_location     = $db->escapeInput($_POST[RequestKey::$PLACE_LOCATION]);
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

      $array_place = array();
      $array_place[RequestKey::$PLACE_NAME]         = $place_name;
      $array_place[RequestKey::$FAMILY_NAME]        = $place_name;
      $array_place[RequestKey::$PLACE_LOCATION]     = $place_location;
      $array_place[RequestKey::$PLACE_CATEGORY]     = '1';
      print_r($array_place);
      if (!$db->isLocationExist($place_location)) {
        if ($place = $db->createPlace($array_place)) {
          // echo "masuk create place | ";
          $family_place_id = (int)$db->lastPlaceId();
          // echo "place id: ". $family_place_id;
          // $family_age =  date_diff(date_create($family_born_date), date_create('today'))->y;
          // $family_age = 10;
          $array_family = array();
          $array_family[RequestKey::$FAMILY_PLACE_ID]    = $family_place_id;
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

          print_r($array_family);
          if ($family = $db->createFamily($array_family)) {
            // echo "Masuk create family | ";
            $keimanan_family_id = (int)$db->lastFamilyId();

            $array_keimanan = array();
            $array_keimanan[RequestKey::$KEIMANAN_FAMILY_ID]  = $keimanan_family_id;
            $array_keimanan[RequestKey::$KEIMANAN_SHOLAT]     = $keimanan_sholat;
            $array_keimanan[RequestKey::$KEIMANAN_MENGAJI]    = $keimanan_mengaji;
            print_r($array_keimanan);

            if ($keimanan = $db->createKeimanan($array_keimanan)) {
              // echo "Masuk create keimanan |";
              $message = 'Sukses membuat keluarga';
              $status = 1;
            }
            else {
              $db->deletePlace($family_place_id);
              $db->deleteFamilyById($keimanan_family_id);
              $status = 2;
              $message = 'gagal create keimanan';
            }
          }
          else{
            $db->deletePlace($family_place_id);
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
            <h2 class="no-margin-bottom">Add family</h2>
          </div>
        </header>
        <section class="dashboard-header">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-body">

                    <form class="form-horizontal" action="create_family.php" method="post">
                      <div class="form-group row">
                        <label class="col-sm-2 form-control-label ">Lokasi</label>
                        <div class="col-sm-8">
                          <input class="form-control" type="text" disabled name="<?= RequestKey::$PLACE_LOCATION ?>" value="<?=$location?>" >
                          <input class="form-control" type="hidden" name="<?= RequestKey::$PLACE_LOCATION ?>" value="<?=$location?>" >
                          <small class="form-text" ><?=$err_location?></small>
                        </div>
                        <div class="col-sm-2">
                          <a class="pull-right btn btn-sm btn-secondary" href="select_place.php">Rubah Lokasi</a>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-2 form-control-label ">Nama Lengkap Kepala Keluarga</label>
                        <div class="col-sm-10">
                          <input class="form-control" type="text" name="<?= RequestKey::$FAMILY_NAME ?>" value="" placeholder="Masukkan Nama Kepala keluarga">
                          <small class="form-text" ><?=$err_name?></small>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-2 form-control-label ">Jenis Kelamin</label>
                        <div class="col-sm-10">
                          <select class="form-control" name="<?=RequestKey::$FAMILY_GENDER?>" required>
                            <option value=""> - Pilih -</option>
                            <option value="1">Laki-laki</option>
                            <option value="2">Perempuan</option>
                          </select>
                          <small class="form-text" ><?=$err_gender?></small>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-2 form-control-label ">Agama</label>
                        <div class="col-sm-10">
                          <select class="form-control" name="<?=RequestKey::$FAMILY_RELIGION?>" required>
                            <option value=""> - Pilih -</option>
                            <option value="1">Islam</option>
                            <option value="2">Kristen</option>
                            <option value="3">Katolik</option>
                            <option value="4">Budha</option>
                            <option value="5">Hindu</option>
                          </select>
                          <small class="form-text" ><?=$err_gender?></small>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-2 form-control-label ">Tempat Lahir</label>
                        <div class="col-sm-10">
                          <input class="form-control" type="text" name="<?= RequestKey::$FAMILY_BORN_PLACE ?>" value="" placeholder="Masukkan Tempat Lahir" required="">
                          <small class="form-text" ><?=$err_born_place?></small>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-2 form-control-label ">Tanggal Lahir</label>
                        <div class="col-sm-10">
                          <input class="form-control" type="date" name="<?= RequestKey::$FAMILY_BORN_DATE ?>" value="" placeholder="" required="">
                          <small class="form-text" ><?=$err_born_date?></small>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-2 form-control-label ">Kategori Usia</label>
                        <div class="col-sm-10">
                          <select class="form-control" name="<?=RequestKey::$FAMILY_AGE?>" required>
                            <option value=""> - Pilih -</option>
                            <option value="1">Balita</option>
                            <option value="2">Anak-anak</option>
                            <option value="3">Remaja</option>
                            <option value="4">Dewasa</option>
                            <option value="5">Lansia</option>
                          </select>
                          <small class="form-text" ><?=$err_gender?></small>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-2 form-control-label ">Pendidikan Terakhir</label>
                        <div class="col-sm-10">
                          <select class="form-control" name="<?=RequestKey::$FAMILY_EDUCATION?>" required>
                            <option value=""> - Pilih-</option>
                            <option value="0">Tidak Ada</option>
                            <option value="1">SD/MI</option>
                            <option value="2">SMP/MTS</option>
                            <option value="3">SMA/MA</option>
                            <option value="4">SMK</option>
                            <option value="5">Diploma (D3/4)</option>
                            <option value="6">Sarjana (S1)</option>
                            <option value="7">Magister (S2)</option>
                            <option value="8">Doktor (S3)</option>
                          </select>
                          <small class="form-text" ><?=$err_education?></small>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-2 form-control-label ">Penghasilan (dalam Rp)</label>
                        <div class="col-sm-10">
                          <input class="form-control" type="number" name="<?= RequestKey::$FAMILY_SALARY ?>" value="" placeholder="Masukkan Penghasilan">
                          <small class="form-text" ><?=$err_salary?></small>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-2 form-control-label ">Golongan Darah</label>
                        <div class="col-sm-10">
                          <select class="form-control" name="<?=RequestKey::$FAMILY_BLOOD?>">
                            <option value=""> - Pilih -</option>
                            <option value="1">A</option>
                            <option value="2">B</option>
                            <option value="3">AB</option>
                            <option value="4">O</option>
                          </select>
                          <small class="form-text" ><?=$err_blood?></small>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-2 form-control-label ">Kebiasaan Sholat</label>
                        <div class="col-sm-10">
                          <select class="form-control" name="<?=RequestKey::$KEIMANAN_SHOLAT?>">
                            <option value=""> - Pilih  -</option>
                            <option value="1">5 waktu</option>
                            <option value="2">tidak 5 waktu</option>
                            <option value="3">Sholat jumat saja</option>
                            <option value="4">Sholat Hari Raya saja</option>
                          </select>
                          <small class="form-text" ><?=$err_sholat?></small>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-2 form-control-label ">Kemampuan Mengaji</label>
                        <div class="col-sm-10">
                          <select class="form-control" name="<?=RequestKey::$KEIMANAN_MENGAJI?>">
                            <option value=""> - Pilih  -</option>
                            <option value="1">Tidak Bisa</option>
                            <option value="2">Kurang Lancar</option>
                            <option value="3">Lancar Membaca</option>
                            <option value="4">Hafal Al-Quran</option>
                          </select>
                          <small class="form-text" ><?=$err_mengaji?></small>
                        </div>
                      </div>
                      <div class="form-group">
                        <input type="hidden" name="<?=RequestKey::$FAMILY_STATUS?>" value="0">
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
