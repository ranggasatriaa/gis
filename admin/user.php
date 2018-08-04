
<?php
session_start();
require_once('../includes/request-key.php');
require_once('../includes/db-helper.php');

if(!isset($_SESSION[RequestKey::$USER_ID])) {
  header('Location: ../.');
}
else {
  $db       = new DBHelper();
  $count    = $db->countUser('1');
  $users    = $db->getAllUser('1');
  // print_r($users->fetch_object());
  $side_bar = 3;
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
            <h2 class="no-margin-bottom">Tamir</h2>
          </div>
        </header>
        <section class="dashboard-header no-padding-bottom">
          <div class="container-fluid">
            <div class="row">
              <div class="statistics col-lg-4">
                <a style="width:100%" href="create_user.php">
                  <div class="statistic d-flex align-items-center bg-white has-shadow">
                    <div class="icon bg-red"><i class="fa fa-plus"></i></div>
                    <div class="text"><strong>Add</strong><br><small>Takmir</small></div>
                  </div>
                </a>
              </div>
              <div class="statistics col-lg-4">
                <div class="statistic d-flex align-items-center bg-white has-shadow">
                  <div class="icon bg-blue"><i class="fa fa-group"></i></div>
                  <div class="text"><strong><?=$count?></strong><br><small>Takmir</small></div>
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
                    <h4>Takmir List</h4>
                  </div>
                  <div class="card-body">

                    <div class="table-responsive">
                      <table class="table table-striped ">
                        <thead>
                          <tr>
                            <th>No</th>
                            <th>Nama Takmir</th>
                            <th>Masjid lokasi takmir</th>
                            <th style="text-align:center">Aksi</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          $i=1;
                          while ($user = $users->fetch_object()) {
                            ?>
                            <tr>
                              <td>
                                <?= $i; ?>
                              </td>
                              <td>
                                <?= ucwords($user->user_name); ?>
                              </td>
                              <td>
                                <?= ucwords($user->masjid_name); ?>
                              </td>
                              <td style="text-align:center">
                                <a class="btn btn-primary btn-sm" href="detail_user.php?<?=RequestKey::$USER_ID.'='.$user->user_id?>">Detail</a>
                                <a class="btn btn-sm btn-secondary" href="#" data-toggle="modal" data-target="#modalUserDelete" data-id="<?=$user->user_id?>" data-name="<?=strtoupper($user->user_name)?>" data-level="Takmir" data-masjid="<?=ucwords($user->masjid_name)?>" ></i> Delete</a>
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
  <div id="modalUserDelete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
    <div role="document" class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 id="exampleModalLabel" class="modal-title">Delete Masjid</h4>
          <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
        </div>
        <div class="modal-body">
          <div class="table-responsive">
            <table class="table">
              <tr>
                <td>Nama</td>
                <td id="user-name"></td>
              </tr>
              <tr>
                <td>Level</td>
                <td id="user-level"></td>
              </tr>
              <tr>
                <td>Masjid</td>
                <td id="user-masjid"></td>
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
              <form id="form-user-delete" method="get" class="pull-right no-margin">
                <input type="hidden" name="user-id" id="user-id-delete">
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

  $('#modalUserDelete').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget)
    var modal = $(this)
    modal.find('#form-user-delete').attr('action','delete_user.php');
    modal.find('.modal-body #user-name').text(button.data('name'));
    modal.find('.modal-body #user-level').text(button.data('level'))
    modal.find('.modal-body #user-masjid').text(button.data('masjid'))
    document.getElementById('user-id-delete').value=button.data('id') ;
  })
  </script>
</body>
</html>
