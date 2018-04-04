
<?php
session_start();
require_once('../includes/request-key.php');
require_once('../includes/db-helper.php');

if(!isset($_SESSION[RequestKey::$USER_ID])) {
  header('Location: ../.');
}
else {

  $pid      = $_GET[RequestKey::$PLACE_ID];
  $db       = new DBHelper();
  $masjid   = $db->getMasjidByPlaceId($pid);
  $place    = $db->getPlaceById($pid);
  $kajians   = $db->getAllKajian($masjid->masjid_id);
  $jumats    = $db->getAllJumat($masjid->masjid_id);

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
      <nav class="side-navbar">
        <!-- Sidebar Header-->
        <div class="sidebar-header d-flex align-items-center">
          <div class="avatar"><img src="../assets/user_img/user/no_image_image.png" alt="..." class="img-fluid rounded-circle" style="height:55px; width: 55px; object-fit: contain;"></div>
          <div class="title">
            <h1 class="h4">ADMIN</h1>
          </div>
        </div>
        <!-- Sidebar Navidation Menus--><span class="heading">Main</span>
        <ul class="list-unstyled">
          <li><a href="."> <i class="icon-home"></i>Dashboard </a></li>
          <li class="active"><a href="place.php"> <i class="fa fa-map-o"></i>Place </a></li>
          <li><a href="profil.php"> <i class="icon-user"></i>Profil </a></li>

        </ul>
      </nav>
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
                    <a class="btn btn-sm btn-primary" href="edit_masjid.php<?=$masjid->masjid_id?>"><i class="fa fa-edit"></i> Edit</a>
                    <a class="btn btn-sm btn-secondary" href="delete_masjid.php<?=$masjid->masjid_id?>"><i class="fa fa-eraser"></i> Delete</a>
                  </div>
                  <div class="card-header">
                    <h4> Masjid <?= $masjid->masjid_name ?></h4>
                  </div>
                  <div class="card-body">
                    <p><?= $masjid->masjid_history ?></p>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="recent-activities card">
                  <div class="card-close">
                    <a class="btn btn-primary btn-sm"href="create_kajian.php?<?=RequestKey::$MASJID_ID?>=<?=$masjid->masjid_id?>"><span claass="fa fa-plus"></span>+ Add</a>
                  </div>
                  <div class="card-header">
                    <h4> Jadual Kajian</h4>
                  </div>
                  <div class="card-body no-padding">
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
                                <div class="icon"><i class="fa fa-calendar-check-o"></i></div>
                              </div>
                            </div>
                            <div style="padding:0px 15px" class="row">
                              <div style=""class="col-8 no-margin no-padding">
                                <span style="padding-right:0px" class="date"> <?=date("g:i", strtotime($kajian->kajian_time)) ?></span><br>
                              </div>
                              <div style="padding-left:0px"class="col-4 no-margin no-padding">
                                <div class="icon"><i class="fa fa-clock-o"></i></div>
                              </div>
                            </div>
                          </div>
                          <div class="col-8 content no-margin">
                            <h5><?=strtoupper($kajian->kajian_title)?> <a href="detail_kajian.php"><i class="fa fa-edit"></i></a></h5> 
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
              <div class="col-md-6">
                <div class="card">
                  <div class="card-close">
                    <a class="btn btn-primary btn-sm"href="create_jumat.php?<?=RequestKey::$MASJID_ID?>=<?=$masjid->masjid_id?>"><span claass="fa fa-plus"></span>+ Add</a>
                  </div>
                  <div class="card-header">
                    <h4> Jadual Imam sholat Jumat</h4>
                  </div>
                  <div class="card-body">
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
</body>
</html>
