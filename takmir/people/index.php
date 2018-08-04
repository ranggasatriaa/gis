
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
  $side_bar   = 2;
  if (isset($_GET['filter'])) {
    $age        = $db->escapeInput($_GET['age']);
    $religion   = $db->escapeInput($_GET['religion']);
    $blood      = $db->escapeInput($_GET['blood']);
    $sholat     = $db->escapeInput($_GET['sholat']);
    $mengaji    = $db->escapeInput($_GET['mengaji']);

    $array              = array();
    $array['age']       = $db->escapeInput($_GET['age']);
    $array['religion']  = $db->escapeInput($_GET['religion']);
    $array['blood']     = $db->escapeInput($_GET['blood']);
    $array['sholat']    = $db->escapeInput($_GET['sholat']);
    $array['mengaji']   = $db->escapeInput($_GET['mengaji']);
    $familys            = $db->getFilterFamily($array);
    // echo $familys;
    if ($familys == false) {
      $message = "Tidak ditemukan";
    }
  }
  else{
    $age        = '';
    $religion   = '';
    $blood      = '';
    $sholat     = '';
    $mengaji    = '';
    $array              = array();
    $array['age']       = '';
    $array['religion']  = '';
    $array['blood']     = '';
    $array['sholat']    = '';
    $array['mengaji']   = '';
    $familys    = $db->getFilterFamily($array);
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
      <?php include('side-navbar.php') ?>

      <div class="content-inner">
        <!-- Page Header-->
        <header class="page-header">
          <div class="container-fluid">
            <h2 class="no-margin-bottom">Masyarakat</h2>
          </div>
        </header>
        <section style="padding:20px 0px" class="dashboard-header">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-header">
                    <form class="form-horisontal" action="index.php" method="get">
                      <label>Tampilkan menurut</label>
                      <div class="row">
                        <div class="col-3 no-margin">
                          <small>Agama</small>
                        </div>
                        <div class="col-3 no-margin">
                          <small>Kelompok Umur</small>
                        </div>
                        <div class="col-3 no-margin">
                          <small>Golongan Darah</small>
                        </div>
                      </div>
                      <div class="row">
                        <div class="form-group col-3 no-margin">
                          <!-- <label>Agama</label> -->
                          <select class="form-control" name="religion">
                            <option value="">Semua Agama</option>
                            <option <?= $religion == 1 ?"selected":""?> value="1">Islam</option>
                            <option <?= $religion == 2 ?"selected":""?> value="2">Kristen</option>
                            <option <?= $religion == 3 ?"selected":""?> value="3">Katolik</option>
                            <option <?= $religion == 4 ?"selected":""?> value="4">Budha</option>
                            <option <?= $religion == 5 ?"selected":""?> value="5">Hindu</option>
                          </select>
                        </div>
                        <div class="from-groip col-3 no-margin">
                          <!-- <label>Kolompok Umur</label> -->
                          <select class="form-control" name="age">
                            <option value="">Semua Umur</option>
                            <option <?= $age == 1 ?"selected":""?> value="1">Balita</option>
                            <option <?= $age == 2 ?"selected":""?> value="2">Anak-anak</option>
                            <option <?= $age == 3 ?"selected":""?> value="3">Remaja</option>
                            <option <?= $age == 4 ?"selected":""?> value="4">Dewasa</option>
                            <option <?= $age == 5 ?"selected":""?> value="5">Lansia</option>
                          </select>
                        </div>
                        <div class="from-groip col-3 no-margin">
                          <!-- <label>Kolompok Umur</label> -->
                          <select class="form-control" name="blood">
                            <option value="">Semua Darah</option>
                            <option <?= $blood == 1 ?"selected":""?> value="1">A</option>
                            <option <?= $blood == 2 ?"selected":""?> value="2">B</option>
                            <option <?= $blood == 3 ?"selected":""?> value="3">AB</option>
                            <option <?= $blood == 4 ?"selected":""?> value="4">O</option>
                          </select>
                        </div>
                        <div style="text-align:right" class="col-3 no-margin">
                          <input class="btn btn-primary"type="submit" name="filter" value="Tampilkan">
                          <a class="btn btn-secondary" href=".">Reset</a>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-4 no-margin">
                          <small>Kebiasaan Sholat</small>
                        </div>
                        <div class="col-5 no-margin">
                          <small>Kemampuan baca Al-Quran</small>
                        </div>
                      </div>
                      <div class="row">
                        <div class="form-group col-4 no-margin">
                          <!-- <label>Agama</label> -->
                          <select class="form-control" name="sholat">
                            <option value="">Semua Kebiasaan</option>
                            <option <?= $sholat == -1 ?"selected":""?> value="-1">Tidak Sholat</option>
                            <option <?= $sholat == 1 ?"selected":""?> value="1">Sholat 5 waktu di masjid</option>
                            <option <?= $sholat == 2 ?"selected":""?> value="2">Sholat 5 waktu di rumah</option>
                            <option <?= $sholat == 3 ?"selected":""?> value="3">Kurang dari 5 waktu di masjid</option>
                            <option <?= $sholat == 4 ?"selected":""?> value="4">Kurang dari 5 waktu di rumah</option>
                            <option <?= $sholat == 5 ?"selected":""?> value="5">Sholat Jumat saja</option>
                            <option <?= $sholat == 6 ?"selected":""?> value="6">Sholat Hari raya saja</option>
                          </select>
                        </div>
                        <div class="from-groip col-5 no-margin">
                          <!-- <label>Kolompok Umur</label> -->
                          <select class="form-control" name="mengaji">
                            <option value="">Semua Kemampuan </option>
                            <option <?= $mengaji == -1 ?"selected":""?> value="-1">Tidak bisa</option>
                            <option <?= $mengaji == 1 ?"selected":""?> value="1">Kurang Lancar</option>
                            <option <?= $mengaji == 2 ?"selected":""?> value="2">Lancar baca</option>
                            <option <?= $mengaji == 3 ?"selected":""?> value="3">Hafal Al-Quran</option>
                          </select>
                        </div>
                      </div>
                    </form>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-striped ">
                        <thead>
                          <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Jenis Umur</th>
                            <th>Agama</th>
                            <th>Jamaah Masjid</th>
                            <th>Aksi</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          if ($familys == false) {
                            echo "<tr>";
                            echo "<th colspan='5' style='text-align:center'>";
                            echo "<h2>Data tidak ditemukan</h2>";
                            echo "</th>";
                            echo "</tr>";
                          }
                          else{
                            $i=1;
                            while ($family = $familys->fetch_object()) {
                              ?>
                              <tr>
                                <td>
                                  <?= $i; ?>
                                </td>
                                <td>
                                  <?= ucwords($family->family_name); ?>
                                </td>
                                <td>
                                  <?php
                                  if ($family->family_age == 1) {
                                    echo "Balita";
                                  }elseif ($family->family_age == 2) {
                                    echo "Anak-anak";
                                  }elseif ($family->family_age == 3) {
                                    echo "Remaja";
                                  }elseif ($family->family_age == 4) {
                                    echo "Dewasa";
                                  }elseif ($family->family_age == 5) {
                                    echo "Lansia";
                                  }else {
                                    echo "Lainnya";
                                  }
                                  ?>
                                </td>
                                <td>
                                  <?php
                                  if ($family->family_religion == 1) {
                                    echo "Islam";
                                  }elseif ($family->family_religion == 2) {
                                    echo "Kristen";
                                  }elseif ($family->family_religion == 3) {
                                    echo "Katolik";
                                  }elseif ($family->family_religion == 4) {
                                    echo "Budha";
                                  }elseif ($family->family_religion == 5) {
                                    echo "Hindu";
                                  }else {
                                    echo "Ateis";
                                  }
                                  ?>
                                </td>
                                <td>
                                  
                                  <?= $family->masjid_id != 0 ? ucwords($family->masjid_name) : 'Belum jadi jamaah masjid manapun'?>
                                </td>
                                <td>
                                  <a  class="btn btn-primary btn-sm" href="detail_anggota.php?<?=RequestKey::$FAMILY_ID?>=<?=$family->family_id?>">Detail</a>
                                </td>
                              </tr>
                              <?php
                              $i += 1;
                            }
                          }
                          ?>
                        </tbody>
                      </table>
                    </div>
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
  <?php include('foot.php'); ?>

  <!-- MODAL DETAIL Masjid -->
  <div id="modalMasjidDelete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
    <div role="document" class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 id="exampleModalLabel" class="modal-title">Detail Masjid</h4>
          <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
        </div>
        <div class="modal-body">
          <div class="table-responsive">
            <table class="table">
              <tr>
                <td>Nama</td>
                <td id="masjid-name"></td>
              </tr>
              <tr>
                <td>Sejarah</td>
                <td id="masjid-history"></td>
              </tr>
            </table>
          </div>
          <div class="dropdown-divider"></div>
          <!-- <input type="hidden" name="kaji" class="form-control" id="file-key"> -->
        </div>
        <div class="modal-footer">
          <div class="row col-12 no-padding ">
            <div class="row col-12">
              <h4>Anda yakan akan menghapus?</h4>
            </div>
            <div class="row col-12">
              <button type="button" data-dismiss="modal" class="btn btn-primary" style="margin-right:10px">No</button>
              <form id="form-masjid-delete" method="get" class="pull-right no-margin">
                <input type="hidden" name="masjid-id" id="masjid-id-delete">
                <button class="btn btn-secondary">Yes</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>

$('#modalMasjidDelete').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget)
  var modal = $(this)
  modal.find('#form-masjid-delete').attr('action','delete_masjid.php');
  modal.find('.modal-body #masjid-name').text(button.data('name'));
  modal.find('.modal-body #masjid-history').text(button.data('history'))
  document.getElementById('masjid-id-delete').value=button.data('id') ;
})
</script>
</body>
</html>
