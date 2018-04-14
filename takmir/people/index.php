
<?php
session_start();
require_once('../../includes/request-key.php');
require_once('../../includes/db-helper.php');

if(!isset($_SESSION[RequestKey::$USER_ID])) {
  header('Location: ../../.');
}
else {
  $db = new DBHelper();
  $side_bar = 2;
  $age      = '';
  $religion = '';
  $familys   = $db->getFilterFamily($age, $religion);
  // $count    = $db->countPlace();
  // $places   = $db->getAllPlace();
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
        <section class="dashboard-header no-padding-bottom">
          <div class="container-fluid">
            <div class="row">

              <div class="statistics col-lg-4">
                <div class="statistic d-flex align-items-center bg-white has-shadow">
                  <div class="icon bg-blue"><i class="fa fa-map-marker"></i></div>
                  <div class="text"><strong><?=$familys->num_rows?></strong><br><small>Orang</small></div>
                </div>
              </div>
            </div>
          </div>
        </section>
        <section class="dashboard-header">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Daftar Masyarakat</h4>
                  </div>
                  <div class="card-body">

                    <div class="table-responsive">
                      <table class="table table-striped ">
                        <thead>
                          <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Agama</th>
                            <th>Jenis Umur</th>
                            <th>Aksi</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
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
                                <a  class="btn btn-primary btn-sm" href="detail_anggota.php?<?=RequestKey::$FAMILY_ID?>=<?=$family->family_id?>">Detail</a>
                              </td>
                            </tr>
                            <?php
                            $i += 1;
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
