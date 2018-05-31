
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

  $db        = new DBHelper();
  $pid       = $_GET[RequestKey::$PLACE_ID];
  $familys    = $db->getFamilyByPlaceId($pid);
  $family_leader = $db->getFamilyLeader($pid);
  $place     = $db->getPlaceById($pid);
  // $kajian_msg= "";
  // $jumat_msg = "";
  // if (!$db->isKajianExist($masjid->masjid_id)) {
  //   $kajian_msg = "Belum ada Kajian";
  // }
  // if (!$db->isJumatExist($masjid->masjid_id)) {
  //   $jumat_msg = "Belum ada Jadual Imam Sholat Jumat";
  // }
  // $kajians   = $db->getAllKajian($masjid->masjid_id);
  // $jumats    = $db->getAllJumat($masjid->masjid_id);

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
            <h2 class="no-margin-bottom">Place Detail</h2>
          </div>
        </header>
        <section class="dashboard-header">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-close">
                    <!-- <a class="btn btn-sm btn-primary" href="edit_masjid.php?<?=RequestKey::$MASJID_ID?>=<?=$masjid->masjid_id?>"><i class="fa fa-edit"></i> Edit</a> -->
                    <a class="btn btn-sm btn-secondary" href="#" data-toggle="modal" data-target="#modalFamilyDelete" data-id="<?=$place->place_id?>" data-name="<?=strtoupper($place->place_name)?>"><i class="fa fa-eraser"></i> Delete</a>

                    <!-- <a class="btn btn-sm btn-secondary" href="delete_masjid.php<?=$masjid->masjid_id?>"><i class="fa fa-eraser"></i> Delete</a> -->
                  </div>
                  <div class="card-header">
                    <h4> Rumah Keluarga <?=$family_leader->family_gender = 1 ? "Pak" : "Bu"?> <?= ucwords($family_leader->family_name) ?></h4>
                  </div>
                  <div class="card-body">
                    <h5>Anggota Keluarga
                    <a class="pull-right btn btn-primary btn-sm" href="create_anggota.php?<?=RequestKey::$PLACE_ID?>=<?=$place->place_id?>">+ Add</a>
                  </h5>
                    <table class="table table-striped">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>Nama</th>
                          <th>Status</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $i=1;
                        while ($family = $familys->fetch_object()) {
                        ?>
                        <tr>
                          <td><?=$i?></td>
                          <td><?=ucwords($family->family_name)?></td>
                          <td><?php
                          if ($family->family_status == 0) {
                            echo "Kepala Keluarga";
                          }elseif ($family->family_status == 1) {
                            echo "Istri ke-".$family->family_status_number;
                          }elseif ($family->family_status == 2) {
                            echo "Anak ke-".$family->family_status_number;
                          }elseif ($family->family_status == 3) {
                            echo "Pembantu";
                          }
                          if ($family->family_die_date != '0000-00-00') {
                            echo ' - meninggal';
                          }
                          ?></td>
                          <td>
                            <a class="btn btn-primary btn-sm" href="detail_anggota.php?<?=RequestKey::$FAMILY_ID?>=<?=$family->family_id?>">Detail</a>
                            <!-- <?=$family->family_name?> -->

                            <!-- <a class="btn btn-primary btn-sm" href="detail_anggota_family.php">Detail</a> -->
                          </td>
                        </tr>
                        <?php
                        $i+=1;
                        } ?>
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


    <!-- MODAL DELTE FAMILY -->
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
