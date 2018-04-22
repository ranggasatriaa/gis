
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
  if(isset($_POST[RequestKey::$FAMILY_ID])
  && isset($_POST[RequestKey::$KEIMANAN_SHOLAT]) && isset($_POST[RequestKey::$KEIMANAN_MENGAJI])){
    // echo "masuk if iset | ";
    $db = new DBHelper();

    //escapeInput
    $family_id          = $db->escapeInput($_POST[RequestKey::$FAMILY_ID]);
    $keimanan_sholat    = $db->escapeInput($_POST[RequestKey::$KEIMANAN_MENGAJI]);
    $keimanan_mengaji   = $db->escapeInput($_POST[RequestKey::$KEIMANAN_SHOLAT]);

    //CEK ERROR PADA INPUTAN
    if(empty($err_blood) && empty($err_sholat) && empty($err_mengaji)){
      // echo "masuk error | ";
      $array_keimanan = array();
      $array_keimanan[RequestKey::$FAMILY_ID]           = $family_id;
      $array_keimanan[RequestKey::$KEIMANAN_SHOLAT]     = $keimanan_sholat;
      $array_keimanan[RequestKey::$KEIMANAN_MENGAJI]    = $keimanan_mengaji;

      // print_r($array_family);
      if ($db->editKeimanan($array_keimanan)) {
        // echo "Masuk create keimanan |";
        $message = 'Sukses edit keimanan';
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
                          <input class="form-control" disabled type="text" name="<?= RequestKey::$FAMILY_NAME ?>" value="<?=ucwords($family->family_name)?>">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-2 form-control-label" >Status di keluarga</label>
                        <div class="col-sm-10">
                          <?php if ($family->family_status == 0) {
                            echo '<input class="form-control" disabled type="text" value="Kepala Keluarga">';
                          }elseif ($family->family_status == 1) {
                            echo '<input class="form-control" disabled type="text" value="Istri">';
                          }elseif ($family->family_status == 2) {
                            echo '<input class="form-control" disabled type="text" value="Anak">';
                          }elseif ($family->family_status == 3) {
                            echo '<input class="form-control" disabled type="text" value="Pembantu">';
                          }
                          ?>
                        </div>
                      </div>
                        <?php if ($family->family_status == 1): ?>
                          <div class="form-group row">
                            <labelclass="col-sm-2 form-control-label ">Istri Ke</label>
                            <div class="col-sm-10">
                              <input disabled class="form-control" type="number" min="0" name="<?=RequestKey::$FAMILY_STATUS_NUMBER?>" value="<?=$family->family_status_number?>">
                              <small class="form-text" ><?=$err_status_number?></small>
                            </div>
                          </div>
                        <?php else: if ($family->family_status == 2) {
                          ?>
                          <div class="form-group row">
                            <labelclass="col-sm-2 form-control-label ">Anak Ke</label>
                            <div class="col-sm-10">
                              <input disabled class="form-control" type="number" min="0" name="<?=RequestKey::$FAMILY_STATUS_NUMBER?>" value="<?=$family->family_status_number?>">
                              <small class="form-text" ><?=$err_status_number?></small>
                            </div>
                          </div>
                          <?php
                        }?>
                        <?php endif; ?>

                      <div class="form-group row">
                        <label class="col-sm-2 form-control-label ">Jenis Kelamin</label>
                        <div class="col-sm-10">
                          <?php if ($family->family_gender == 1) {
                            echo '<input class="form-control" disabled type="text" value="Laki-laki">';
                          }elseif ($family->family_gender == 2) {
                            echo '<input class="form-control" disabled type="text" value="Perempuan">';
                          }
                          ?>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-2 form-control-label ">Agama</label>
                        <div class="col-sm-10">
                          <?php if ($family->family_religion == 1) {
                            echo '<input class="form-control" disabled type="text" value="Islam">';
                          }elseif ($family->family_religion == 2) {
                            echo '<input class="form-control" disabled type="text" value="Kristen">';
                          }elseif ($family->family_religion == 3) {
                            echo '<input class="form-control" disabled type="text" value="Katolik">';
                          }elseif ($family->family_religion == 4) {
                            echo '<input class="form-control" disabled type="text" value="Budha">';
                          }elseif ($family->family_religion == 5) {
                            echo '<input class="form-control" disabled type="text" value="Hindu">';
                          }
                          ?>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-2 form-control-label ">Tempat Lahir</label>
                        <div class="col-sm-10">
                          <input class="form-control" disabled type="text" name="<?= RequestKey::$FAMILY_BORN_PLACE ?>" value="<?=$family->family_born_date?>" placeholder="Masukkan Tempat Lahir" required="">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-2 form-control-label ">Tanggal Lahir</label>
                        <div class="col-sm-10">
                          <input class="form-control" disabled type="date" name="<?= RequestKey::$FAMILY_BORN_DATE ?>" value="<?=$family->family_born_date?>" placeholder="" required="">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-2 form-control-label ">Kategori Usia</label>
                        <div class="col-sm-10">
                          <?php if ($family->family_age == 1) {
                            echo '<input class="form-control" disabled type="text" value="Balita">';
                          }elseif ($family->family_age == 2) {
                            echo '<input class="form-control" disabled type="text" value="Anak-anak">';
                          }elseif ($family->family_age == 3) {
                            echo '<input class="form-control" disabled type="text" value="Remaja">';
                          }elseif ($family->family_age == 4) {
                            echo '<input class="form-control" disabled type="text" value="Dewasa">';
                          }elseif ($family->family_age == 5) {
                            echo '<input class="form-control" disabled type="text" value="Lansia">';
                          }
                          ?>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-2 form-control-label ">Pendidikan Terakhir</label>
                        <div class="col-sm-10">
                          <?php if ($family->family_education == 0) {
                            echo '<input class="form-control" disabled type="text" value="Tidak Ada">';
                          }elseif ($family->family_education == 1) {
                            echo '<input class="form-control" disabled type="text" value="SD/MI">';
                          }elseif ($family->family_education == 2) {
                            echo '<input class="form-control" disabled type="text" value="SMP/MTS">';
                          }elseif ($family->family_education == 3) {
                            echo '<input class="form-control" disabled type="text" value="SMA/MA">';
                          }elseif ($family->family_education == 4) {
                            echo '<input class="form-control" disabled type="text" value="SMK">';
                          }elseif ($family->family_education == 5) {
                            echo '<input class="form-control" disabled type="text" value="Diploma (D3/4)">';
                          }elseif ($family->family_education == 6) {
                            echo '<input class="form-control" disabled type="text" value="Sarjana (S1)">';
                          }elseif ($family->family_education == 7) {
                            echo '<input class="form-control" disabled type="text" value="Magister (S2)">';
                          }elseif ($family->family_education == 8) {
                            echo '<input class="form-control" disabled type="text" value="Doktor (S3)">';
                          }
                          ?>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-2 form-control-label ">Penghasilan (dalam Rp)</label>
                        <div class="col-sm-10">
                          <input class="form-control" disabled type="number" name="<?= RequestKey::$FAMILY_SALARY ?>" value="<?=$family->family_salary?>" placeholder="Masukkan Penghasilan">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-2 form-control-label ">Status Kawin</label>
                        <div class="col-sm-10">
                          <?php if ($family->family_blood == 0) {
                            echo '<input class="form-control" disabled type="text" value="Belum Kawin">';
                          }elseif ($family->family_blood == 1) {
                            echo '<input class="form-control" disabled type="text" value="Kawin">';
                          }elseif ($family->family_blood == 2) {
                            echo '<input class="form-control" disabled type="text" value="Janda/duda cerai hidup">';
                          }elseif ($family->family_blood == 3) {
                            echo '<input class="form-control" disabled type="text" value="Janda/duda cerai mati">';
                          }else
                          ?>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-2 form-control-label ">Golongan Darah</label>
                        <div class="col-sm-10">
                          <?php if ($family->family_blood == 1) {
                            echo '<input class="form-control" disabled type="text" value="A">';
                          }elseif ($family->family_blood == 2) {
                            echo '<input class="form-control" disabled type="text" value="B">';
                          }elseif ($family->family_blood == 3) {
                            echo '<input class="form-control" disabled type="text" value="AB">';
                          }elseif ($family->family_blood == 4) {
                            echo '<input class="form-control" disabled type="text" value="O">';
                          }
                          ?>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-2 form-control-label ">Kesediaan Donor</label>
                        <div class="col-sm-10">
                          <?php if ($family->family_donor == 1) {
                            echo '<input class="form-control" disabled type="text" value="Bersedia">';
                          }elseif ($family->family_donor == 0) {
                            echo '<input class="form-control" disabled type="text" value="Tidak Besedia">';
                          }
                          ?>
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
                        <a class="btn btn-secondary" href="detail_anggota.php?<?=RequestKey::$FAMILY_ID?>=<?=$family->family_id?>">Cancel</a>
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
        window.location.href = "detail_anggota.php?<?=RequestKey::$FAMILY_ID?>=<?=$family->family_id?>" + escape(window.location.href);
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
