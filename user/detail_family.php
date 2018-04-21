
<?php
session_start();
require_once('../includes/request-key.php');
require_once('../includes/db-helper.php');

$db             = new DBHelper();
$pid            = $_GET[RequestKey::$PLACE_ID];
$familys        = $db->getFamilyByPlaceId($pid);
$family_leader  = $db->getFamilyLeader($pid);
$place          = $db->getPlaceById($pid);

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
    <div class="page-content d-flex align-items-stretch row">
      <!-- Side Navbar -->
      <div class="content-inner col-lg-12">
        <!-- Page Header-->
        <header class="page-header">
          <div class="container-fluid col-12 row">
            <h2 class="no-margin-bottom col-8">Place Detail</h2>
            <a href="../." class="text-right col-4"><h7 > Kembali <span class="fa fa-arrow-right"></span></h7></a>
          </div>
        </header>
        <section class="dashboard-header">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-header">
                    <h4> Rumah Keluarga <?=$family_leader->family_gender = 1 ? "Pak" : "Bu"?> <?= $family_leader->family_name ?></h4>
                  </div>
                  <div class="card-body">
                    <h5>Anggota Keluarga</h5>
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
                            <td><?=$family->family_name?></td>
                            <td><?php
                            if ($family->family_status == 0) {
                              echo "Kepala Keluarga";
                            }elseif ($family->family_status == 1) {
                              echo "Anak Pertama";
                            }elseif ($family->family_status == 2) {
                              echo "Anggota Keluarga";
                            }elseif ($family->family_status == 3) {
                              echo "Pembantu";
                            }
                            ?></td>
                            <td>
                              <a  class="btn btn-primary btn-sm" href="detail_anggota.php?<?=RequestKey::$FAMILY_ID?>=<?=$family->family_id?>">Detail</a>

                              <!-- <?=$family->family_name?> -->
                              <!-- <a class="btn btn-sm btn-primary" href="#" data-toggle="modal" data-target="#modalAnggotaKeluarga"
                              data-id="<?=$family->family_id?>"
                              data-name="<?=strtoupper($family->family_name)?>"
                              data-status="<?php if ($family->family_status = 0) {
                                echo 'Kepala keluarga';
                              }elseif ($family->family_status = 1) {
                                echo 'Anak Pertama';
                              }elseif ($family->family_status = 2) {
                                echo 'Anggota Keluarga';
                              }elseif ($family->family_status = 3) {
                                echo 'Pembantu';
                              }
                              ?>"
                              data-gender="<?=$family->family_gender?>"
                              data-age="<?=$family->family_age?>"
                              data-born-place="<?=strtoupper($family->family_born_place)?>"
                              data-born-date="<?=date('d F Y',strtotime($family->family_born_date))?>"
                              data-education="<?=$family->family_education?>"
                              data-salary="<?=$family->family_salary?>"
                              data-blood="<?=$family->family_blood?>" >
                              <i class=""></i> Detail</a> -->
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
                  <td>Umur</td>
                  <td id="family-age"></td>
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
          </div>
        </div>
      </div>
    </div>


    <script>
    //javascript modal anggota keluarga
    $('#modalAnggotaKeluarga').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget)
      var modal = $(this)
      modal.find('.modal-body #family-name').text(button.data('name'))
      modal.find('.modal-body #family-status').text(button.data('status'))
      modal.find('.modal-body #family-age').text(button.data('age'))
      // modal.find('.modal-body #family-born').text(button.data('born-place')+", "+button.data('born-date'))
      // modal.find('.modal-body #family-age').text(button.data('age'))
      modal.find('.modal-body #family-education').text(button.data('education'))
      modal.find('.modal-body #family-salary').text(button.data('salary'))
      modal.find('.modal-body #family-blood').text(button.data('blood'))

      // modal.find('.modal-body #family-id').text(button.data('id'))
    })


    </script>
  </body>
  </html>
