
<?php
require_once('../includes/request-key.php');
require_once('../includes/db-helper.php');

$db             = new DBHelper();
$pid            = $_GET[RequestKey::$PLACE_ID];
$masjid         = $db->getMasjidByPlaceId($pid);
$place          = $db->getPlaceById($pid);
$kajian_msg     = "";
$jumat_msg      = "";
$kegiatan_msg  = "";

if (!$db->isKajianExist($masjid->masjid_id)) {
  $kajian_msg = "Belum ada Kajian";
}
if (!$db->isJumatExist($masjid->masjid_id)) {
  $jumat_msg = "Belum ada Jadual Imam Sholat Jumat";
}
if (!$db->isKegiatanExist($masjid->masjid_id)) {
  $kegiatan_msg = "Belum ada Kegiatan di masjid ini";
}
$kajians   = $db->getAllKajian($masjid->masjid_id);
$jumats    = $db->getAllJumat($masjid->masjid_id);
$kegiatans  = $db->getAllKegiatan($masjid->masjid_id);

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
                    <h4> Masjid <?= $masjid->masjid_name ?></h4>
                  </div>
                  <div class="card-body">
                    <p><?= $masjid->masjid_history ?></p>
                  </div>
                </div>
              </div>
            </div>

            <!-- KAJIAN -->
            <div class="row">
              <div class="col-md-7">
                <div class="recent-activities card">
                  <div class="card-header">
                    <div class="row">
                      <div class="col-8 no-margin">
                        <h4> Jadual Kajian</h4>
                      </div>
                      <div class="col-4 no-margin text-right">
                      </div>
                    </div>
                  </div>
                  <div class="card-body no-padding">
                    <?php if ($kajian_msg !="") {
                      echo "<h4 style='text-align:center; padding:5px'>".$kajian_msg."</h4>";
                    }?>
                    <?php while ($kajian = $kajians->fetch_object()) {
                      ?>
                      <div class="item">
                        <div class="row">
                          <div class="col-4 date-holder text-right no-margin">
                            <div style="padding:0px 15px" class="row">
                              <div style="padding-right:0px"class="col-8 no-margin no-padding">
                                <span style="padding-right:0px" class="date text-info"> <?=date("d-m-Y", strtotime($kajian->kajian_date)) ?></span><br>
                              </div>
                              <div style="padding-left:0px"class="col-4 no-margin no-padding">
                                <div style="padding-top:0px" class="icon"><i class="fa fa-calendar-check-o"></i></div>
                              </div>
                            </div>
                            <div style="padding:0px 15px" class="row">
                              <div style=""class="col-8 no-margin no-padding">
                                <span style="padding-right:0px" class="date"> <?=date("g:i", strtotime($kajian->kajian_time)) ?></span><br>
                              </div>
                              <div style="padding-left:0px"class="col-4 no-margin no-padding">
                                <div style="padding-top:0px" class="icon"><i class="fa fa-clock-o"></i></div>
                              </div>
                            </div>
                          </div>
                          <div class="col-8 content no-margin">
                            <!-- <a class="pull-right" href="#" data-toggle="modal" data-target="#modalKajian" data-id="<?=$kajian->kajian_id?>" data-date="<?=date('d F Y',strtotime($kajian->kajian_date))?>" data-time="<?=date('g:i',strtotime($kajian->kajian_time))?>" data-title="<?=$kajian->kajian_title?>" data-description="<?=$kajian->kajian_description?>" data-speaker="<?=$kajian->kajian_speaker?>"><i class="fa fa-edit"></i></a> -->
                            <h5><?=strtoupper($kajian->kajian_title)?>
                              <!-- <a href="detail_kajian.php"><i class="fa fa-edit"></i></a> -->
                            </h5>
                            <p><?=$kajian->kajian_description?></p>
                            <h6><bold>Pengisi: <?=$kajian->kajian_speaker?></bold><h6>
                            </div>
                          </div>
                        </div>
                        <?php
                      } ?>
                    </div>
                  </div>
                </div>

                <!-- IMAM -->
                <div class="col-md-5">
                  <div class=" recent-activities card">
                    <div class="card-header">
                      <div class="row">
                        <div class="col-8 no-margin">
                          <h4> Jadual Imam sholat Jumat</h4>
                        </div>
                        <div class="col-4 no-margin text-right">
                          </div>
                      </div>
                    </div>
                    <div class="card-body no-padding">
                      <?php if ($jumat_msg !="") {
                        echo "<h4 style='text-align:center; padding:5px'>".$jumat_msg."</h4>";
                      }?>
                      <?php
                      while ($jumat = $jumats->fetch_object()) {
                        ?>
                        <div class="item">
                          <div class="row">
                            <div class="col-4 date-holder text-right no-margin">
                              <div style="padding-top:0px" class="icon"><i class="fa fa-calendar-check-o"></i></div>
                              <div class="date"><span class="text-info"><?=$jumat->jumat_date?></span></div>
                            </div>
                            <div class="col-8 content no-margin">
                              <!-- <a class="pull-right" href="#" data-toggle="modal" data-target="#modalJumat" data-id="<?=$jumat->jumat_id?>" data-date="<?=date('d F Y',strtotime($jumat->jumat_date))?>" data-imam="<?=ucwords($jumat->jumat_imam)?>"><i class="fa fa-edit"></i></a> -->
                              <p style="margin-bottom:10px">Imam</p>
                              <h5><?=$jumat->jumat_imam?></h5>
                            </div>
                          </div>
                        </div>
                        <?php
                      }
                      ?>
                    </div>
                  </div>
                </div>
              </div>

              <!-- KEGIATAN -->
              <div class="row">
                <div class="col-md-12">
                  <div class="recent-activities card">
                    <div class="card-header">
                      <div class="row">
                        <div class="col-8 no-margin">
                          <h4> Jadual Kegiatan</h4>
                        </div>
                      </div>
                    </div>
                    <div class="card-body no-padding">
                      <?php if ($kegiatan_msg !="") {
                        echo "<h4 style='text-align:center; padding:5px'>".$kegiatan_msg."</h4>";
                      }?>
                      <?php while ($kegiatan = $kegiatans->fetch_object()) {
                        ?>
                        <div class="item">
                          <div class="row">
                            <div class="col-3 date-holder text-right no-margin">
                              <div style="padding:0px 15px" class="row">
                                <div style="padding-right:0px"class="col-8 no-margin no-padding">
                                  <span style="padding-right:0px" class="date text-info"> <?=date("d-m-Y", strtotime($kegiatan->kegiatan_date)) ?></span><br>
                                </div>
                                <div style="padding-left:0px"class="col-4 no-margin no-padding">
                                  <div style="padding-top:0px" class="icon"><i class="fa fa-calendar-check-o"></i></div>
                                </div>
                              </div>
                              <div style="padding:0px 15px" class="row">
                                <div style=""class="col-8 no-margin no-padding">
                                  <span style="padding-right:0px" class="date"> <?=date("g:i", strtotime($kegiatan->kegiatan_time)) ?></span><br>
                                </div>
                                <div style="padding-left:0px"class="col-4 no-margin no-padding">
                                  <div style="padding-top:0px" class="icon"><i class="fa fa-clock-o"></i></div>
                                </div>
                              </div>
                            </div>
                            <div class="col-9 content no-margin">
                              <h5><?=strtoupper($kegiatan->kegiatan_title)?>
                                <!-- <a href="detail_kegiatan.php"><i class="fa fa-edit"></i></a> -->
                              </h5>
                              <p><?=$kegiatan->kegiatan_description?></p>
                              </div>
                            </div>
                          </div>
                          <?php
                        } ?>
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
    <!-- MODAL DETAIL KAJIAN -->
    <div id="modalKajian" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
      <div role="document" class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 id="exampleModalLabel" class="modal-title">Detail Kajian</h4>
            <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
          </div>
          <div class="modal-body">
            <div class="table-responsive">
              <table class="table">
                <tr>
                  <td>Tanggal</td>
                  <td id="kajian-date"></td>
                </tr>
                <tr>
                  <td>Waktu</td>
                  <td id="kajian-time"></td>
                </tr>
                <tr>
                  <td>Judul</td>
                  <td id="kajian-title"></td>
                </tr>
                <tr>
                  <td>Deskripsi</td>
                  <td id="kajian-description"></td>
                </tr>
                <tr>
                  <td>Pengisi</td>
                  <td id="kajian-speaker"></td>
                </tr>
              </table>
            </div>
            <div class="dropdown-divider"></div>
            <!-- <input type="hidden" name="kaji" class="form-control" id="file-key"> -->
          </div>
          <div class="modal-footer">

          </div>
        </div>
      </div>
    </div>

    <!-- MODAL DETAIL JUMAT -->
    <div id="modalJumat" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
      <div role="document" class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 id="exampleModalLabel" class="modal-title">Detail Jumat</h4>
            <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
          </div>
          <div class="modal-body">
            <div class="table-responsive">
              <table class="table">
                <tr>
                  <td>Tanggal</td>
                  <td id="jumat-date"></td>
                </tr>
                <tr>
                  <td>Imam</td>
                  <td id="jumat-imam"></td>
                </tr>
              </table>
            </div>
            <div class="dropdown-divider"></div>
            <!-- <input type="hidden" name="kaji" class="form-control" id="file-key"> -->
          </div>
        </div>
      </div>
    </div>


  <script>
  //javascript modal kajian
  $('#modalKajian').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget)
    var modal = $(this)
    modal.find('#formedit').attr('action','edit_kajian.php');
    modal.find('#formdelete').attr('action','delete_kajian.php');
    modal.find('.modal-body #kajian-date').text(button.data('date'))
    modal.find('.modal-body #kajian-time').text(button.data('time'))
    modal.find('.modal-body #kajian-title').text(button.data('title'))
    modal.find('.modal-body #kajian-description').text(button.data('description'))
    modal.find('.modal-body #kajian-speaker').text(button.data('speaker'))
  })

  //javascript modal jumat
  $('#modalJumat').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget)
    var modal = $(this)
    modal.find('#form-jumat-edit').attr('action','edit_jumat.php');
    modal.find('#form-jumat-delete').attr('action','delete_jumat.php');
    modal.find('.modal-body #jumat-date').text(button.data('date'))
    modal.find('.modal-body #jumat-imam').text(button.data('imam'))
  })
  //javascript modal masjid
  </script>
</body>
</html>
