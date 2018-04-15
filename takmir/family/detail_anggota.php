
<?php
session_start();
require_once('../../includes/request-key.php');
require_once('../../includes/db-helper.php');

if(!isset($_SESSION[RequestKey::$USER_ID])) {
  header('Location: ../../.');
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
            <h2 class="no-margin-bottom">Detail Anggota</h2>
          </div>
        </header>
        <section class="dashboard-header">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-12">
                <div class="card">

                  <div class="card-header">
                    <h4> Detail Anggota Keluarga</h4>
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
                          echo 'Anak Pertama';
                        }elseif ($family->family_status == 2) {
                          echo 'Anggota Keluarga';
                        }elseif ($family->family_status == 3) {
                          echo 'Pembantu';
                        }
                        ?></td>
                      </tr>
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
                        <th width ="20%">Agama</th>
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
                        <td><?=$family->family_education?></td>
                      </tr>
                      <tr>
                        <th width="20%">Pendapatan</th>
                        <td>:</td>
                        <td><?=$family->family_salary?></td>
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

                      <tr>
                        <th>Kebiasaan Shalat</th>
                        <td>:</td>
                        <td><?php if($keimanan->keimanan_sholat == 1){
                          echo '5 Waktu';
                        }elseif($keimanan->keimanan_sholat == 2){
                          echo 'Tidak 5 Waktu';
                        }elseif($keimanan->keimanan_sholat == 3){
                          echo 'Sholat Jumat Saja';
                        }elseif($keimanan->keimanan_sholat == 4){
                          echo 'Sholat Hari Raya Saja';
                        }else{
                          echo 'Lainnya';
                        }?></td>
                      </tr>
                      <tr>
                        <th>Kemampuan Mengaji</th>
                        <td>:</td>
                        <td><?php if($keimanan->keimanan_mengaji == 1){
                          echo 'Tidak Bisa';
                        }elseif($keimanan->keimanan_mengaji == 2){
                          echo 'Kurang Lancar';
                        }elseif($keimanan->keimanan_mengaji == 3){
                          echo 'Lancar Membaca';
                        }elseif($keimanan->keimanan_mengaji == 4){
                          echo 'Hafal Al-Quran';
                        }else{
                          echo 'Lainnya';
                        }?></td>
                      </tr>
                      <tr>
                        <td style="text-align:right" colspan="3">
                          <a class="pull-left btn btn-secondary btn-sm" href="detail_family.php?<?=RequestKey::$PLACE_ID?>=<?=$family->place_id?>">Kembali</a>
                          <a class="btn btn-primary btn-sm" href="edit_anggota.php?<?=RequestKey::$FAMILY_ID?>=<?=$family->family_id?>">Edit</a>
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

  <!-- MODAL DETAIL KAJIAN -->
  <div id="modalAnggotaKeluarga" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
    <div role="document" class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 id="exampleModalLabel" class="modal-title">Detail Anggota</h4>
          <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
        </div>
        <div class="modal-body">
          <div class="table-responsive">
            <table class="table">
              <tr>
                <td>Nama</td>
                <td id="family-name"></td>
              </tr>
              <tr>
                <td>Status</td>
                <td id="family-status"></td>
              </tr>
              <tr>
                <td>Jenis Kelamin</td>
                <td id="family-gender"></td>
              </tr>
              <tr>
                <td>TTL</td>
                <td id="family-born"></td>
              </tr>
              <tr>
                <td>Agama</td>
                <td id="family-religion"></td>
              </tr>
              <tr>
                <td>Edukasi</td>
                <td id="family-education"></td>
              </tr>
              <tr>
                <td>Penghasilan</td>
                <td id="family-salary"></td>
              </tr>
              <tr>
                <td>Golongan Darah</td>
                <td id="family-blood"></td>
              </tr>
            </table>
          </div>
          <div class="dropdown-divider"></div>
          <!-- <input type="hidden" name="kaji" class="form-control" id="file-key"> -->
        </div>
        <div class="modal-footer">
          <div class="row col-12 no-padding">
            <div class="col-9 no-padding">
              <button type="button" data-dismiss="modal" class="btn btn-secondary">Close</button>
              <form id="form-anggota-edit" method="get" class="pull-right">
                <input type="hidden" name="family-id" id="family-id-edit">
                <button class="btn btn-primary">Edit</button>
              </form>
            </div>
            <div class="col-3 no-padding-left ">
              <form id="form-anggota-delete" method="get" class="pull-right">
                <input type="hidden" name="family-id" id="family-id-delete">
                <button class="btn btn-secondary">Delete</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- MODAL DETAIL KAJIAN -->
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

  <script>
  //javascript modal anggota keluarga
  $('#modalAnggotaKeluarga').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget)
    var modal = $(this)
    modal.find('#form-anggota-edit').attr('action','edit_anggota.php');
    modal.find('#form-anggota-delete').attr('action','delete_anggota.php');
    modal.find('.modal-body #family-name').text(button.data('name'));
    modal.find('.modal-body #family-status').text(button.data('status'));
    modal.find('.modal-body #family-gender').text(button.data('gender'));
    modal.find('.modal-body #family-religion').text(button.data('religion'));
    modal.find('.modal-body #family-born').text(button.data('born-place')+", "+button.data('born-date'));
    modal.find('.modal-body #family-age').text(button.data('age'));
    modal.find('.modal-body #family-education').text(button.data('education'));
    modal.find('.modal-body #family-salary').text(button.data('salary'));
    modal.find('.modal-body #family-blood').text(button.data('blood'));
    document.getElementById('family-id-edit').value=button.data('id') ;
    document.getElementById('family-id-delete').value=button.data('id') ;

    // modal.find('.modal-body #family-id').text(button.data('id'))
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
