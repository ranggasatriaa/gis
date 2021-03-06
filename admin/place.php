
<?php
session_start();
require_once('../includes/request-key.php');
require_once('../includes/db-helper.php');

if(!isset($_SESSION[RequestKey::$USER_ID])) {
  header('Location: ../.');
}if ($_SESSION[RequestKey::$USER_LEVEL] != 0){
  header('Location: ../unauthorize.php');
}
else {
  $db = new DBHelper();
  $side_bar = 2;
  $count    = $db->countPlace();
  $places  = $db->getAllPlace();
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
            <h2 class="no-margin-bottom">Place</h2>
          </div>
        </header>
        <section class="dashboard-header no-padding-bottom">
          <div class="container-fluid">
            <div class="row">
              <div class="statistics col-lg-4">
                <a style="width:100%" href="masjid/select_place.php">
                  <div class="statistic d-flex align-items-center bg-white has-shadow">
                    <div class="icon bg-red"><i class="fa fa-plus"></i></div>
                    <div class="text"><strong>Add</strong><br><small>Masjid</small></div>
                  </div>
                </a>
              </div>
              <div class="statistics col-lg-4">
                <a style="width:100%" href="family/select_place.php">
                  <div class="statistic d-flex align-items-center bg-white has-shadow">
                    <div class="icon bg-red"><i class="fa fa-plus"></i></div>
                    <div class="text"><strong>Add</strong><br><small>Family</small></div>
                  </div>
                </a>
              </div>
              <div class="statistics col-lg-4">
                <div class="statistic d-flex align-items-center bg-white has-shadow">
                  <div class="icon bg-blue"><i class="fa fa-map-marker"></i></div>
                  <div class="text"><strong><?=$count?></strong><br><small>Place</small></div>
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
                    <h4>Place List</h4>
                  </div>
                  <div class="card-body">

                    <div class="table-responsive">
                      <table class="table table-striped ">
                        <thead>
                          <tr>
                            <th>No</th>
                            <th>Nama Lokasi</th>
                            <th>Lokasi</th>
                            <th>Jenis</th>
                            <th>Aksi</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          $i=1;
                          while ($place = $places->fetch_object()) {
                            ?>
                            <tr>
                              <td>
                                <?= $i; ?>
                              </td>
                              <td>
                                <?= ucwords($place->place_name); ?>
                              </td>
                              <td>
                                <?= $place->place_location ?>
                              </td>
                              <td>
                                <?= ((int)$place->place_category == 0 ? '<p class="text-success">Masjid</p>' : '<p class="text-danger">Rumah</p>' ) ?>
                              </td>
                              <td>
                                <?= ((int)$place->place_category == 0 ? '<a class="btn btn-primary btn-sm " href="masjid/detail_masjid.php?'.RequestKey::$PLACE_ID.'='.$place->place_id.'">Detail</a>' : '<a class="btn btn-primary btn-sm" href="family/detail_family.php?'.RequestKey::$PLACE_ID.'='.$place->place_id.'">Detail</a>' ) ?>
                                <!-- <a class="btn btn-sm btn-secondary" href="#" data-toggle="modal" data-target="#modalMasjidDelete" data-id="<?=$masjid->masjid_id?>" data-name="<?=strtoupper($masjid->masjid_name)?>" data-history="<?=$masjid->masjid_history?>" ><i class="fa fa-eraser"></i> Delete</a>

                                <button type="button" data-toggle="modal" data-target="#modalMajisDelete" class="btn btn-secondary middle btn-sm" data-name="<?=$place->place_name?>" data-location="<?=$place->place_location?>" data-category="<?=$place->place_category?>">Delete</button> -->
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
