
<?php
session_start();
require_once('../includes/request-key.php');
require_once('../includes/db-helper.php');

if(!isset($_SESSION[RequestKey::$USER_ID])) {
  header('Location: ../.');
}
else {
  $db = new DBHelper();
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
            <h2 class="no-margin-bottom">Place</h2>
          </div>
        </header>
        <section class="dashboard-header no-padding-bottom">
          <div class="container-fluid">
            <div class="row">
              <div class="statistics col-lg-4">
                <a style="width:100%" href="masjid/create_masjid.php">
                  <div class="statistic d-flex align-items-center bg-white has-shadow">
                    <div class="icon bg-red"><i class="fa fa-plus"></i></div>
                    <div class="text"><strong>Add</strong><br><small>Place</small></div>
                  </div>
                </a>
              </div>
              <div class="statistics col-lg-4">
                <a style="width:100%" href="create_family.php">
                  <div class="statistic d-flex align-items-center bg-white has-shadow">
                    <div class="icon bg-red"><i class="fa fa-plus"></i></div>
                    <div class="text"><strong>Add</strong><br><small>Family</small></div>
                  </div>
                </a>
              </div>
              <div class="statistics col-lg-4">
                <div class="statistic d-flex align-items-center bg-white has-shadow">
                  <div class="icon bg-blue"><i class="fa fa-user"></i></div>
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
                                <?= ((int)$place->place_category == 0 ? '<a class="btn btn-primary btn-sm " href="masjid/detail_masjid.php?'.RequestKey::$PLACE_ID.'='.$place->place_id.'">Detail</a>' : '<a class="btn btn-primary btn-sm" href="family/detail_family.php">Detail</a>' ) ?>
                                <button type="button" data-toggle="modal" data-target="#modalUpgrade" class="btn btn-secondary middle btn-sm" data-name="<?=$place->place_name?>" data-location="<?=$place->place_location?>" data-category="<?=$place->place_category?>">Delete</button>
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
</body>
</html>
