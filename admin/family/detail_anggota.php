
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

  $db         = new DBHelper();
  $side_bar   = 2;
  if (isset($_GET[RequestKey::$FAMILY_ID])) {
    $fid      = $_GET[RequestKey::$FAMILY_ID];
    $family   = $db->getFamilyById($fid);
    $keimanan = $db->getKeimananByFamilyId($fid);
  }else {
    header('Location: ../place.php');
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
            <h2>Detail Anggota</h2>
          </div>
        </header>
        <section class="dashboard-header">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-header">
                    <h4> Detail Anggota Keluarga
                      <?php if ($family->family_die_date == NULL || $family->family_die_date == '0000-00-00'): ?>
                        <a class="pull-right btn btn-secondary btn-sm" href="die_family.php?<?=RequestKey::$FAMILY_ID?>=<?=$family->family_id?>">Anggota Meninggal</a>
                        <?php else: ?>
                        <a class="pull-right btn btn-secondary btn-sm" href="life_family.php?<?=RequestKey::$FAMILY_ID?>=<?=$family->family_id?>">Anggota Tidak Meninggal</a>
<!--                        <span class="pull-right">-->
<!--                            Anggota ini telah Meninggal-->
<!--                          </span>-->
                      <?php endif; ?>
                    </h4>
                  </div>
                  <div class="card-body">
                  </h5>
                  <table class="table">
                    <tbody>
                      <tr>
                        <th width="20%">Nama</th>
                        <td>:</td>
                        <td><?=$family->family_name?></td>
                      </tr>
                      <tr>
                        <th width="20%">Status</th>
                        <td>:</td>
                        <td><?php if ($family->family_status == 0) {
                          echo 'Kepala keluarga';
                        }elseif ($family->family_status == 1) {
                          echo 'Istri';
                        }elseif ($family->family_status == 2) {
                          echo 'Anak';
                        }elseif ($family->family_status == 3) {
                          echo 'Pembantu';
                        }
                        ?></td>
                      </tr>
                      <?php if ($family->family_status == 1){
                        ?>
                        <tr>
                          <th>Istri ke</th>
                          <td>:</td>
                          <td><?=$family->family_status_number?></td>
                        </tr>
                        <?php
                      }elseif ($family->family_status == 2) {
                        ?>
                        <tr>
                          <th>Anak ke</th>
                          <td>:</td>
                          <td><?=$family->family_status_number?></td>
                        </tr>
                        <?php
                      }
                      ?>
                      <tr>
                        <th width="20%">Jenis Kelamin</th>
                        <td>:</td>
                        <td><?php if ($family->family_gender == 1) {
                          echo 'Laki-laki';
                        }elseif ($family->family_gender == 2) {
                          echo 'Perempuan';
                        }else{
                          echo 'Lain-lain';
                        }
                        ?></td>
                      </tr>
                      <tr>
                        <th width="20%">Agama</th>
                        <td>:</td>
                        <td><?php if($family->family_religion == 1){
                          echo 'Islam';
                        }elseif($family->family_religion == 2){
                          echo 'Kristen';
                        }elseif($family->family_religion == 3){
                          echo 'Katolik';
                        }elseif($family->family_religion == 4){
                          echo 'Budha';
                        }elseif($family->family_religion == 5){
                          echo 'Hindu';
                        }else{
                          echo 'Lainnya';
                        }
                        ?></td>
                      </tr>
                      <tr>
                        <th width="20%">TTL</th>
                        <td>:</td>
                        <td><?=strtoupper($family->family_born_place)?>, <?=date('d F Y',strtotime($family->family_born_date))?></td>
                      </tr>
                      <tr>
                        <th width="20%">Golongan Umur</th>
                        <td>:</td>
                        <td><?php if($family->family_age == 1){
                          echo 'Balita';
                        }elseif($family->family_age == 2){
                          echo 'Anak-anak';
                        }elseif($family->family_age == 3){
                          echo 'Remaja';
                        }elseif($family->family_age == 4){
                          echo 'Dewasa';
                        }elseif($family->family_age == 5){
                          echo 'Lansia';
                        }else{
                          echo 'Lainnya';
                        }?></td>
                      </tr>
                      <tr>
                        <th width="20%">Pendidikan Terakhir</th>
                        <td>:</td>
                        <td><?php if($family->family_education == 0){
                          echo 'Tidak Ada';
                        }elseif($family->family_education == 1){
                          echo 'SD/MI';
                        }elseif($family->family_education == 2){
                          echo 'SMP/MTS';
                        }elseif($family->family_education == 3){
                          echo 'SMA/MA';
                        }elseif($family->family_education == 4){
                          echo 'SMK';
                        }elseif($family->family_education == 5){
                          echo 'Diploma (D3/4)';
                        }elseif($family->family_education == 6){
                          echo 'Sarjana (S1)';
                        }elseif($family->family_education == 7){
                          echo 'Magister (S2)';
                        }elseif($family->family_education == 8){
                          echo 'Doktor (S3)';
                        }else{
                          echo 'Lainnya';
                        }?></td>
                      </tr>
                      <tr>
                        <th width="20%">Penghasilan</th>
                        <td>:</td>
                        <td>Rp <?=$family->family_salary?>,-</td>
                      </tr>
                      <tr>
                        <th width="20%">Status Kawin</th>
                        <td>:</td>
                        <td><?php if($family->family_kawin == 0){
                          echo 'Belum kawin';
                        }elseif($family->family_kawin == 1){
                          echo 'Kawin';
                        }elseif($family->family_kawin == 2){
                          echo 'Janda/duda cerai hidup';
                        }elseif($family->family_kawin == 3){
                          echo 'Janda/duda cerai mati';
                        }else{
                          echo 'Lainnya';
                        }?></td>
                      </tr>
                      <tr>
                        <th width="20%">Golongan Darah</th>
                        <td>:</td>
                        <td><?php if($family->family_blood == 1){
                          echo 'A';
                        }elseif($family->family_blood == 2){
                          echo 'B';
                        }elseif($family->family_blood == 3){
                          echo 'AB';
                        }elseif($family->family_blood == 4){
                          echo 'O';
                        }else{
                          echo 'Lainnya';
                        }?></td>
                      </tr>
                      <?php if ($family->family_age >= 3) {
                        ?>
                        <tr>
                          <th width="20%">Ketersediaan Donor</th>
                          <td>:</td>
                          <td><?php if($family->family_donor == 1){
                            echo 'Bersedia';
                          }else{
                            echo 'Tidak Bersedia';
                          }?></td>
                        </tr>
                        <?php
                      }
                      if ($family->family_religion == 1) {
                        ?>
                        <tr>
                          <th>Kebiasaan Shalat</th>
                          <td>:</td>
                          <td><?php if($keimanan->keimanan_sholat == -1){
                            echo 'Tidak Sholat';
                          }elseif($keimanan->keimanan_sholat == 1){
                            echo '5 waktu di masjid';
                          }elseif($keimanan->keimanan_sholat == 2){
                            echo '5 waktu di rumah';
                          }elseif($keimanan->keimanan_sholat == 3){
                            echo 'tidak 5 waktu di masjid';
                          }elseif($keimanan->keimanan_sholat == 4){
                            echo 'tidak 5 waktu di rumah';
                          }elseif($keimanan->keimanan_sholat == 5){
                            echo 'Sholat Jumat Saja';
                          }elseif($keimanan->keimanan_sholat == 6){
                            echo 'Sholat Hari Raya Saja';
                          }else{
                            echo 'Lainnya';
                          }?></td>
                        </tr>
                        <tr>
                          <th>Kemampuan Membaca Al-Quran</th>
                          <td>:</td>
                          <td><?php if($keimanan->keimanan_mengaji == -1){
                            echo 'Tidak Bisa';
                          }elseif($keimanan->keimanan_mengaji == 1){
                            echo 'Kurang Lancar';
                          }elseif($keimanan->keimanan_mengaji == 2){
                            echo 'Lancar Membaca';
                          }elseif($keimanan->keimanan_mengaji == 3){
                            echo 'Hafal Al-Quran';
                          }else{
                            echo 'Lainnya';
                          }?></td>
                        </tr>
                        <?php
                      }
                      ?>
                      <tr>
                        <td style="text-align:right" colspan="3">
                          <a class="pull-left btn btn-secondary btn-sm" href="detail_family.php?<?=RequestKey::$PLACE_ID?>=<?=$family->place_id?>">Kembali</a>
                          <a class="btn btn-primary btn-sm" href="edit_anggota.php?<?=RequestKey::$FAMILY_ID?>=<?=$family->family_id?>">Edit</a>
                          <a class="btn btn-sm btn-danger" href="#" data-toggle="modal" data-target="#modalAnggotaDelete" data-id="<?=$family->family_id?>" data-name="<?=strtoupper($family->family_name)?>"></i> Delete</a>

                          <!-- <a class="btn btn-danger btn-sm" href="delete_anggota.php?<?=RequestKey::$FAMILY_ID?>=<?=$family->family_id?>">Delete</a> -->
                        </td>
                      </tr>
                    </tbody>
                  </table>
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

  <!-- MODAL Delete Family -->
  <div id="modalFamilyDelete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
    <div role="document" class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 id="exampleModalLabel" class="modal-title">Delete Keluarga</h4>
          <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
        </div>
        <div class="modal-body">
          <div class="table-responsive">
            <table class="table">
              <tr>
                <td>Nama</td>
                <td id="place-name"></td>
              </tr>
            </table>
          </div>
          <div class="dropdown-divider"></div>
          <!-- <input type="hidden" name="kaji" class="form-control" id="file-key"> -->
        </div>
        <div class="modal-footer">
          <div class="row col-12 no-padding">
            <h4>Anda yakin ingin menghapus?</h4>
            <div class="col-9 no-padding">
              <button type="button" data-dismiss="modal" class="btn btn-secondary">No </button>
            </div>
            <div class="col-3 no-padding-left ">
              <form id="formdelete" method="get" class="pull-right">
                <input type="hidden" name="place-id" id="place-id-delete">
                <button class="btn btn-primary">Yes</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- MODAL Delete anggota-->
  <div id="modalAnggotaDelete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
    <div role="document" class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 id="exampleModalLabel" class="modal-title">Delete Anggota</h4>
          <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
        </div>
        <div class="modal-body">
          <div class="table-responsive">
            <table class="table">
              <tr>
                <td>Nama</td>
                <td id="user-name"></td>
              </tr>
            </table>
          </div>
          <div class="dropdown-divider"></div>
          <!-- <input type="hidden" name="kaji" class="form-control" id="file-key"> -->
        </div>
        <div class="modal-footer">
          <div class="row col-12 no-padding ">
            <div class="row col-12">
              <h4>Anda yakin akan menghapus?</h4>
            </div>
            <div class="row col-12">
              <button type="button" data-dismiss="modal" class="btn btn-primary" style="margin-right:10px">No</button>
              <form id="form-anggota-delete" method="get" class="pull-right no-margin">
                <input type="hidden" name="family-id" id="user-id-anggota-delete">
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

$('#modalAnggotaDelete').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget)
  var modal = $(this)
  modal.find('#form-anggota-delete').attr('action','delete_anggota.php');
  modal.find('.modal-body #user-name').text(button.data('name'));
  document.getElementById('user-id-anggota-delete').value=button.data('id') ;
})


//javascript modal kajian
$('#modalFamilyDelete').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget)
  var modal = $(this)
  // modal.find('#formedit').attr('action','edit_family.php');
  modal.find('#formdelete').attr('action','delete_family.php');
  modal.find('.modal-body #place-name').text(button.data('name'))

  document.getElementById('place-id-delete').value=button.data('id') ;
  // document.getElementById('family-id-delete').value=button.data('salary') ;
})

</script>
</body>
</html>
