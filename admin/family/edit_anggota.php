
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
  $db = new DBHelper();

  $status          = 0;
  $message         = '';
  $err_location    = '';
  $err_name        = '';
  $err_status      = '';
  $err_status_number= '';
  $err_kawin       = '';
  $err_religion    = '';
  $err_age         = '';
  $err_gender      = '';
  $err_born_place  = '';
  $err_born_date   = '';
  $err_education   = '';
  $err_salary      = '';
  $err_blood       = '';
  $err_donor       = '';
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
  && isset($_POST[RequestKey::$FAMILY_STATUS])
  && isset($_POST[RequestKey::$FAMILY_RELIGION]) && isset($_POST[RequestKey::$FAMILY_GENDER])
  && isset($_POST[RequestKey::$FAMILY_BORN_PLACE]) && isset($_POST[RequestKey::$FAMILY_BORN_DATE])
  && isset($_POST[RequestKey::$FAMILY_SALARY])  && isset($_POST[RequestKey::$FAMILY_BLOOD])
){
  // echo "masuk if iset | ";
  $db = new DBHelper();

  //escapeInput
  $place_name           = $db->escapeInput($_POST[RequestKey::$FAMILY_NAME]);
  $family_id            = $db->escapeInput($_POST[RequestKey::$FAMILY_ID]);
  $family_name          = $db->escapeInput($_POST[RequestKey::$FAMILY_NAME]);
  $family_status        = $db->escapeInput($_POST[RequestKey::$FAMILY_STATUS]);
  if (isset($_POST[RequestKey::$FAMILY_STATUS_NUMBER])) {
    $family_status_number = $db->escapeInput($_POST[RequestKey::$FAMILY_STATUS_NUMBER]);
  }else {
    $family_status_number = -1;
  }
  $family_kawin         = $db->escapeInput($_POST[RequestKey::$FAMILY_KAWIN]);
  $family_religion      = $db->escapeInput($_POST[RequestKey::$FAMILY_RELIGION]);
  $family_gender        = $db->escapeInput($_POST[RequestKey::$FAMILY_GENDER]);
  $family_born_place    = $db->escapeInput($_POST[RequestKey::$FAMILY_BORN_PLACE]);
  $family_born_date     = $db->escapeInput($_POST[RequestKey::$FAMILY_BORN_DATE]);
  $family_education     = $db->escapeInput($_POST[RequestKey::$FAMILY_EDUCATION]);
  $family_salary        = $db->escapeInput($_POST[RequestKey::$FAMILY_SALARY]);
  $family_blood         = $db->escapeInput($_POST[RequestKey::$FAMILY_BLOOD]);
  $family_donor         = $db->escapeInput($_POST[RequestKey::$FAMILY_DONOR]);
  $keimanan_sholat      = $db->escapeInput($_POST[RequestKey::$KEIMANAN_MENGAJI]);
  $keimanan_mengaji     = $db->escapeInput($_POST[RequestKey::$KEIMANAN_SHOLAT]);


    if (date_create($family_born_date) >= date_create(date("Y-m-d"))) {
      $err_born_date = "Tanggal Tidak Valid";
    }

  //CEK ERROR PADA INPUTAN
  if(empty($err_name) && empty($err_gender) && empty($err_born_place)
  && empty($err_religion) && empty($err_born_date) && empty($err_education)
  && empty($err_salary) && empty($err_blood) && empty($err_sholat) && empty($err_mengaji)){
    // echo "masuk error | ";

    $diff = date_diff(date_create($family_born_date), date_create(date("Y-m-d")));
    $age = $diff->format('%y');
    //DEFIN KATEGORI AGE
    if ($age < 6) {
      $family_age = 1; //balita
    }elseif($age >= 5 && $age < 12){
      $family_age = 2; //kanak2
    }elseif($age >= 12 && $age < 17){
      $family_age = 3; //remaja awal
    }elseif($age >= 17 && $age < 26){
      $family_age = 4; //remaja akhir
    }elseif($age >= 26 && $age < 36){
      $family_age = 5; //dewasa awal
    }elseif($age >= 36 && $age < 46){
      $family_age = 6; //dewasa akhir
    }elseif($age >= 46 && $age < 56){
      $family_age = 7; //lansia awal
    }elseif($age >= 56 && $age < 66){
      $family_age = 8; //lansia akhir
    }elseif($age >= 66){
      $family_age = 9; //manula
    }

    $array_family = array();
    $array_family[RequestKey::$FAMILY_ID]             = $family_id;
    $array_family[RequestKey::$FAMILY_NAME]           = $family_name;
    $array_family[RequestKey::$FAMILY_STATUS]         = $family_status;
    $array_family[RequestKey::$FAMILY_STATUS_NUMBER]  = $family_status_number;
    $array_family[RequestKey::$FAMILY_KAWIN]          = $family_kawin;
    $array_family[RequestKey::$FAMILY_AGE]            = $family_age;
    $array_family[RequestKey::$FAMILY_RELIGION]       = $family_religion;
    $array_family[RequestKey::$FAMILY_GENDER]         = $family_gender;
    $array_family[RequestKey::$FAMILY_BORN_PLACE]     = $family_born_place;
    $array_family[RequestKey::$FAMILY_BORN_DATE]      = $family_born_date ;
    $array_family[RequestKey::$FAMILY_EDUCATION]      = $family_education;
    $array_family[RequestKey::$FAMILY_SALARY]         = $family_salary;
    $array_family[RequestKey::$FAMILY_BLOOD]          = $family_blood;
    $array_family[RequestKey::$FAMILY_DONOR]          = $family_donor;
    $array_keimanan = array();
    $array_keimanan[RequestKey::$FAMILY_ID]           = $family_id;
    $array_keimanan[RequestKey::$KEIMANAN_SHOLAT]     = $keimanan_sholat;
    $array_keimanan[RequestKey::$KEIMANAN_MENGAJI]    = $keimanan_mengaji;

    // print_r($array_family);
    if ($db->editFamily($array_family) && $db->editKeimanan($array_keimanan)) {
      // echo "Masuk edit |";
      $status = 1;
      $message = 'Sukses edit anggota';
    }
    else {
      $status = 2;
      $message = 'Gagal edit';
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
                    <form class="form-horizontal" action="edit_anggota.php?<?=RequestKey::$FAMILY_ID?>=<?=$fid?>" method="post">
                      <div class="form-group row">
                        <label class="col-sm-2 form-control-label ">Nama Lengkap</label>
                        <div class="col-sm-10">
                          <input class="form-control" type="text" name="<?= RequestKey::$FAMILY_NAME ?>" value="<?=$family->family_name?>" placeholder="Masukkan Nama Kepala keluarga">
                          <small class="form-text" ><?=$err_name?></small>
                        </div>
                      </div>
                      <?php if ($family->family_status == 0){ ?>
                        <input type="hidden" name="<?=RequestKey::$FAMILY_STATUS?>" value="0">
                      <?php }else{ ?>
                        <div class="form-group row">
                          <label class="col-sm-2 form-control-label ">Status di keluarga</label>
                          <div class="col-sm-10">
                            <select id="status" class="form-control" name="<?=RequestKey::$FAMILY_STATUS?>" required>
                              <option value=""> - Pilih -</option>
                              <option value="1" <?=$family->family_status == 1 ? "selected":""?> >Istri</option>
                              <option value="2" <?=$family->family_status == 2 ? "selected":""?> >Anak</option>
                              <option value="3" <?=$family->family_status == 3 ? "selected":""?> >Pembantu</option>
                            </select>
                            <small class="form-text" ><?=$err_status?></small>
                          </div>
                        </div>
                        <div  id="status_number" style="display:block">
                          <div class="form-group row">
                            <label id="status_number_istri" style="display:none" class="col-sm-2 form-control-label ">Istri Ke</label>
                            <label id="status_number_anak" style="display:block" class="col-sm-2 form-control-label ">Istri/Anak Ke</label>
                            <div class="col-sm-10">
                              <input class="form-control" type="number" min="0" name="<?=RequestKey::$FAMILY_STATUS_NUMBER?>" value="<?=$family->family_status_number?>">
                              <small class="form-text" ><?=$err_status_number?></small>
                            </div>
                          </div>
                        </div>
                      <?php } ?>
                      <div class="form-group row">
                        <label class="col-sm-2 form-control-label ">Jenis Kelamin</label>
                        <div class="col-sm-10">
                          <select class="form-control" name="<?=RequestKey::$FAMILY_GENDER?>" required>
                            <option value=""> - Pilih -</option>
                            <option id="laki" value="1" <?=$family->family_gender == 1 ? "selected":""?> >Laki-laki</option>
                            <option value="2" <?=$family->family_gender == 2 ? "selected":""?> >Perempuan</option>
                          </select>
                          <small class="form-text" ><?=$err_gender?></small>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-2 form-control-label ">Agama</label>
                        <div class="col-sm-10">
                          <select id="religion" class="form-control" name="<?=RequestKey::$FAMILY_RELIGION?>" required>
                            <option value=""> - Pilih-</option>
                            <option value="1" <?=$family->family_religion == 1 ? "selected":""?> >Islam</option>
                            <option value="2" <?=$family->family_religion == 2 ? "selected":""?> >Kristen</option>
                            <option value="3" <?=$family->family_religion == 3 ? "selected":""?> >Katolik</option>
                            <option value="4" <?=$family->family_religion == 4 ? "selected":""?> >Budha</option>
                            <option value="5" <?=$family->family_religion == 5 ? "selected":""?> >Hindu</option>
                            <option value="6" <?=$family->family_religion == 6 ? "selected":""?> >Lainnya</option>
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
                        <label class="col-sm-2 form-control-label ">Pendidikan Terakhir</label>
                        <div class="col-sm-10">
                          <select class="form-control" name="<?=RequestKey::$FAMILY_EDUCATION?>" required>
                            <option value=""> - Pilih-</option>
                            <option value="0"<?=$family->family_education == 0 ? "selected":""?>>Tidak Ada</option>
                            <option value="1"<?=$family->family_education == 1 ? "selected":""?>>SD/MI</option>
                            <option value="2"<?=$family->family_education == 2 ? "selected":""?>>SMP/MTS</option>
                            <option value="3"<?=$family->family_education == 3 ? "selected":""?>>SMA/MA</option>
                            <option value="4"<?=$family->family_education == 4 ? "selected":""?>>SMK</option>
                            <option value="5"<?=$family->family_education == 5 ? "selected":""?>>Diploma (D3/4)</option>
                            <option value="6"<?=$family->family_education == 6 ? "selected":""?> >Sarjana (S1)</option>
                            <option value="7"<?=$family->family_education == 7 ? "selected":""?> >Magister (S2)</option>
                            <option value="8"<?=$family->family_education == 8 ? "selected":""?> >Doktor (S3)</option>
                          </select>
                          <small class="form-text" ><?=$err_education?></small>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-2 form-control-label ">Penghasilan (dalam Rp)</label>
                        <div class="col-sm-10">
                          <input class="form-control" type="number" min="0" name="<?= RequestKey::$FAMILY_SALARY ?>" value="<?=$family->family_salary?>" placeholder="Masukkan Penghasilan">
                          <small class="form-text" ><?=$err_salary?></small>
                        </div>
                      </div>
                      <div  id="kawin" style="display:<?=$family->family_age >=3 ? 'block' : 'none'?>">
                        <div class="form-group row">
                          <label class="col-sm-2 form-control-label ">Status Kawin</label>
                          <div class="col-sm-10">
                            <select class="form-control" name="<?=RequestKey::$FAMILY_KAWIN?>">
                              <option value=""> - Pilih -</option>
                              <option value="0" <?=$family->family_kawin == 0 ? "selected":""?> >Belum Kawin</option>
                              <option value="1" <?=$family->family_kawin == 1 ? "selected":""?> >Kawin</option>
                              <option value="2" <?=$family->family_kawin == 2 ? "selected":""?> >Janda/duda cerai hidup</option>
                              <option value="3" <?=$family->family_kawin == 3 ? "selected":""?> >Janda/duda cerai mati</option>
                            </select>
                            <small class="form-text" ><?=$err_kawin?></small>
                          </div>
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
                      <div  id="donor" style="display:<?=$family->family_age >=3 ? 'block' : 'none'?>">
                        <div class="form-group row">
                          <label class="col-sm-2 form-control-label ">Kesediaan Donor</label>
                          <div class="col-sm-10">
                            <select class="form-control" name="<?=RequestKey::$FAMILY_DONOR?>">
                              <option value=""> - Pilih -</option>
                              <option value="1" <?=$family->family_donor == 1 ? "selected":""?> >Bersedia</option>
                              <option value="0" <?=$family->family_donor == 0 ? "selected":""?> >Tidak bersedia</option>
                            </select>
                            <small class="form-text" ><?=$err_donor?></small>
                          </div>
                        </div>
                      </div>
                      <div id="keimanan" style="display:none">
                        <div class="form-group row">
                          <label class="col-sm-2 form-control-label ">Kebiasaan Sholat</label>
                          <div class="col-sm-10">
                            <select class="form-control" name="<?=RequestKey::$KEIMANAN_SHOLAT?>">
                              <option value=""> - Pilih  -</option>
                              <option value="-1" <?=$keimanan->keimanan_sholat == -1 ? "selected":""?> >Tidak Sholat</option>
                              <option value="1" <?=$keimanan->keimanan_sholat == 1 ? "selected":""?> >5 waktu di masjid</option>
                              <option value="2" <?=$keimanan->keimanan_sholat == 2 ? "selected":""?> >5 waktu di rumah</option>
                              <option value="3" <?=$keimanan->keimanan_sholat == 3 ? "selected":""?> >kurang 5 waktu di masjid</option>
                              <option value="4" <?=$keimanan->keimanan_sholat == 4 ? "selected":""?> >kurang 5 waktu di rumah</option>
                              <option value="5" <?=$keimanan->keimanan_sholat == 5 ? "selected":""?> >Sholat jumat saja</option>
                              <option value="6" <?=$keimanan->keimanan_sholat == 6 ? "selected":""?> >Sholat Hari Raya saja</option>
                            </select>
                            <small class="form-text" ><?=$err_sholat?></small>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label class="col-sm-2 form-control-label ">Kemampuan Membaca Al-Quran</label>
                          <div class="col-sm-10">
                            <select class="form-control" name="<?=RequestKey::$KEIMANAN_MENGAJI?>">
                              <option value=""> - Pilih  -</option>
                              <option value="-1" <?=$keimanan->keimanan_mengaji == -1 ? "selected":""?> >Tidak Bisa</option>
                              <option value="1" <?=$keimanan->keimanan_mengaji == 1 ? "selected":""?> >Kurang Lancar</option>
                              <option value="2" <?=$keimanan->keimanan_mengaji == 2 ? "selected":""?> >Lancar Membaca</option>
                              <option value="3" <?=$keimanan->keimanan_mengaji == 3 ? "selected":""?> >Hafal Al-Quran</option>
                            </select>
                            <small class="form-text" ><?=$err_mengaji?></small>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <input type="hidden" name="<?=RequestKey::$FAMILY_ID?>" value="<?=$fid?>">
                        <a class="btn btn-secondary" href="detail_family.php?<?=RequestKey::$PLACE_ID?>=<?=$family->place_id?>">Cancel</a>
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
  echo '<script>var status = '.$status.'; var message = "'.$message.'";</script>';
  $status = 0;
  // $message = '';
  ?>
  <script>
  $('#status').on('change',function(){
    if( $(this).val()==="1"){
      $("#status_number").show()
      $("#status_number_istri").show()
      $("#status_number_anak").hide()
      $("#balita").hide()
      $("#anak").hide()
      $("#laki").hide()

    }
    else if ( $(this).val()==="2") {
      $("#status_number").show()
      $("#status_number_anak").show()
      $("#status_number_istri").hide()
      $("#balita").show()
      $("#anak").show()
      $("#laki").show()

    }else{
      $("#status_number").hide()
      $("#status_number_anak").hide()
      $("#status_number_anak").hide()
      $("#balita").hide()
      $("#anak").show()
      $("#laki").show()

    }
  });

  $('#religion').on('change',function(){
    if( $(this).val()==="1"){
      $("#keimanan").show()
    }
    else{
      $("#keimanan").hide()
    }
  });

  $('#age').on('change',function(){
    if( $(this).val()==="3" || $(this).val()==="4" || $(this).val()==="5"){
      $("#donor").show()
      $("#kawin").show()
    }
    else{
      $("#donor").hide()
      $("#kawin").hide()
    }
  });

  $(document).ready(function() {
    if (status == 1) {
      swal("Success!",message,"success")
      .then((value) => {
        window.location.href = "detail_anggota.php?family-id=<?=$family->family_id?>" + escape(window.location.href);
        // header('Location: detail_family.php?place-id='.$family->place_id.'');

      })
    }
    else if (status == 2) {
      swal("Failed!",message,"error");
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
