
<?php
session_start();
require_once('../includes/request-key.php');
require_once('../includes/db-helper.php');

if(isset($_SESSION[RequestKey::$USER_LEVEL])) {
  if ($_SESSION[RequestKey::$USER_LEVEL] == 0) {
    header('Location: admin/.');
  }else{
    header('Location: takmir/.');
  }
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
    <div class="row">
      <div class="col-lg-12">

        <!-- Page Header-->
        <header class="page-header">
          <div class="container-fluid col-12 row">
            <h2 class="no-margin-bottom col-8">Detail Anggota Keluarga</h2>
            <a href="detail_family.php?place-id=<?=$family->place_id?>" class="text-right col-4"><h7 > Kembali <span class="fa fa-arrow-right"></span></h7></a>
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
                        <td><?php if ($family->family_status = 0) {
                          echo 'Kepala keluarga';
                        }elseif ($family->family_status = 1) {
                          echo 'Anak Pertama';
                        }elseif ($family->family_status = 2) {
                          echo 'Anggota Keluarga';
                        }elseif ($family->family_status = 3) {
                          echo 'Pembantu';
                        }
                        ?></td>
                      </tr>
                      <tr>
                        <th width="20%">Jenis Kelamin</th>
                        <td>:</td>
                        <td><?php if ($family->family_gender = 1) {
                          echo 'Laki-laki';
                        }elseif ($family->family_gender = 2) {
                          echo 'Perempuan';
                        }else{
                          echo 'Lain-lain';
                        }
                        ?></td>
                      </tr>
                      <tr>
                        <th width="20%">Agama</th>
                        <td>:</td>
                        <td><?php if($family->family_religion = 1){
                          echo 'Islam';
                        }elseif($family->family_religion = 2){
                          echo 'Kristen';
                        }elseif($family->family_religion = 3){
                          echo 'Katolik';
                        }elseif($family->family_religion = 4){
                          echo 'Budha';
                        }elseif($family->family_religion = 5){
                          echo 'Hindu';
                        }else{
                          echo 'Lainnya';
                        }
                        ?></td>
                      </tr>
                      <tr>
                        <th width="20%">Golongan Umur</th>
                        <td>:</td>
                        <td><?php if($family->family_age = 1){
                          echo 'Balita';
                        }elseif($family->family_age = 2){
                          echo 'Anak-anak';
                        }elseif($family->family_age = 3){
                          echo 'Remaja';
                        }elseif($family->family_age = 4){
                          echo 'Dewasa';
                        }elseif($family->family_age = 5){
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
                        <td><?php if($family->family_blood = 1){
                          echo 'A';
                        }elseif($family->family_blood = 2){
                          echo 'B';
                        }elseif($family->family_blood = 3){
                          echo 'AB';
                        }elseif($family->family_blood = 4){
                          echo 'O';
                        }else{
                          echo 'Lainnya';
                        }?></td>
                      </tr>

                      <tr>
                        <th>Kebiasaan Shalat</th>
                        <td>:</td>
                        <td><?php if($family->family_blood = 1){
                          echo '5 Waktu di Masjid';
                        }elseif($family->family_blood = 2){
                          echo 'Tidak 5 Waktu';
                        }elseif($family->family_blood = 3){
                          echo 'Sholat Jumat Saja';
                        }elseif($family->family_blood = 4){
                          echo 'Sholat Hari Raya Saja';
                        }else{
                          echo 'Lainnya';
                        }?></td>
                      </tr>
                      <tr>
                        <th>Kemampuan Membaca Al-QUran</th>
                        <td>:</td>
                        <td><?php if($family->family_blood = 1){
                          echo 'Tidak Bisa';
                        }elseif($family->family_blood = 2){
                          echo 'Kurang Lancar';
                        }elseif($family->family_blood = 3){
                          echo 'Lancar Membaca';
                        }elseif($family->family_blood = 4){
                          echo 'Hafal Al-Quran';
                        }else{
                          echo 'Lainnya';
                        }?></td>
                      </tr>
                      <tr>
                        <td style="text-align:right" colspan="3">
                          <a class="pull-left btn btn-secondary btn-sm" href="detail_family.php?place-id=<?=$family->place_id?>">Kembali</a>
                          <!-- <a class="btn btn-primary btn-sm" href="edit_anggota.php?<?=RequestKey::$FAMILY_ID?>=<?=$family->family_id?>">Edit</a> -->
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
</body>
</html>
