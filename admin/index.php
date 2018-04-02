<?php
session_start();
require_once('../includes/request-key.php');
require_once('../includes/db-helper.php');

if(!isset($_SESSION[RequestKey::$USER_ID])) {
  header('Location: ../.');
}
else {
  $db = new DBHelper();
  $place1 = $db->getPlaceById(3);
  $places = $db->getAllPlace();
  $count  = $db->countPlace();

  $location = array();
  $category = array();
  $i=1;
  while ($place = $places->fetch_object()) {
    $location[$i] = $place->place_location;
    $name[$i] = $place->place_name;
    $category[$i] = $place->place_category;
    $i += 1;
  }
  // echo $count;
  // print_r($location);
  // print_r($category);
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Geocoding service</title>
  <?php include('head.php'); ?>

  <style>
  /* Always set the map height explicitly to define the size of the div
  * element that contains the map. */
  #map {
    height: 300px;
    padding: 0 30px;
    display: flex;
    flex-wrap: wrap;
    margin-right: 30px;
    margin-left: 30px;

  }
  /* Optional: Makes the sample page fill the window. */
  html, body {
    height: 100%;
    margin: 0;
    padding: 0;
  }
  #floating-panel {
    position: absolute;
    top: 10px;
    left: 25%;
    z-index: 5;
    background-color: #fff;
    padding: 5px;
    border: 1px solid #999;
    text-align: center;
    font-family: 'Roboto','sans-serif';
    line-height: 30px;
    padding-left: 10px;
  }
  </style>
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
          <li class="active"><a href="."> <i class="icon-home"></i>Dashboard </a></li>
          <li><a href="profil.php"> <i class="icon-user"></i>Profil </a></li>
        </ul>
      </nav>
      <div class="content-inner">
        <!-- Page Header-->
        <header class="page-header">
          <div class="container-fluid">
            <h2 class="no-margin-bottom">Dashboard</h2>
          </div>
        </header>
        <!--data user  -->
        <section class="dashboard-header">
          <div class="container-fluid">
            <div class="row">
              <div class="statistics col-lg-4">
                <a style="width:100%" href="create.php">
                  <div class="statistic d-flex align-items-center bg-white has-shadow">
                    <div class="icon bg-blue"><i class="fa fa-plus"></i></div>
                    <div class="text"><strong>Tambah</strong><br><small>Lokasi</small></div>
                  </div>
                </a>
              </div>
              <div class="statistics col-lg-4">
                <div class="statistic d-flex align-items-center bg-white has-shadow">
                  <div class="icon bg-red"><i class="fa fa-user"></i></div>
                  <div class="text"><strong><?=$count?></strong><br><small>Lokasi</small></div>
                </div>
                <!-- <div class="statistic d-flex align-items-center bg-white has-shadow">
                <div class="icon bg-green"><i class="fa fa-desktop"></i></div>
                <div class="text"><strong><?=($totalFile->size/1000).' kb';?></strong><br><small>Memory</small></div>
              </div> -->
            </div>
          </div>
        </div>
      </section>
      <!-- Dashboard Header Section    -->

      <div id="map"></div>
      <section class="dashboard-header">
        <div class="container-fluid">
          <div class="row">
            <div class="col-lg-12">

              <div class="table-responsive">
                <table class="table table-striped ">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Nama Lokasi</th>
                      <th>Lokasi</th>
                      <th>Status</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>

                    <?php

                    // while ($place = $places->fetch_object()) {
                    for ($i=1; $i <=$count ; $i++) {
                      ?>
                      <tr>
                        <td>
                          <?= $i; ?>
                        </td>
                        <td>
                          <?= ucwords($name[$i]); ?>
                        </td>
                        <td>
                          <?= $location[$i] ?>
                        </td>
                        <td>
                          <?= ((int)$category[$i] == 0 ? '<p class="text-success">Masjid</p>' : '<p class="text-warning">Rumah</p>' ) ?>
                        </td>
                        <td>
                          <button type="button" data-toggle="modal" data-target="#modalUpgrade" class="btn btn-primary middle btn-sm" data-name="<?=$place->place_name?>" data-location="<?=$place->place_location?>" data-category="<?=$place->place_category?>">Detail</button>
                          <button type="button" data-toggle="modal" data-target="#modalUpgrade" class="btn btn-primary middle btn-sm" data-name="<?=$place->place_name?>" data-location="<?=$place->place_location?>" data-category="<?=$place->place_category?>">Delete</button>
                        </td>
                      </tr>
                      <?php

                    }

                    ?>
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

<script>

var myStyles =[
  {
    featureType: "poi",
    elementType: "labels",
    stylers: [
      { visibility: "off" }
    ]
  }
];
function initMap() {
  var map = new google.maps.Map(document.getElementById('map'), {
    zoom: 17,
    center: {lat: -7.058202, lng: 110.426634},
    // animation: google.maps.Animation.DROP,
    // disableDefaultUI: true
    styles: myStyles
  });

  var iconBase = 'https://maps.google.com/mapfiles/kml/shapes/';
  var icons = {
    rumah: {
      icon: iconBase + 'library_maps.png'
    },
    masjid: {
      icon: iconBase + 'info-i_maps.png'
    }
  };

  //Show marker
  var features = [
    <?php
    for ($i=1; $i <=$count ; $i++) {
      echo "{
        position: new google.maps.LatLng(".$location[$i]."),
        type:'";
        if ($category[$i] == 0) {
          echo "masjid";
        }else {
          echo "rumah";
        }
        echo"'},";
      }
      ?>
    ];


    // Create markers.
    features.forEach(function(feature) {
      var marker = new google.maps.Marker({
        position: feature.position,
        icon: icons[feature.type].icon,
        map: map
      });
    });

  }

  </script>
  <script async defer
  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCqQT371I-5H38pipkOoE3_0eIvcFpho5w&callback=initMap">
  </script>
</body>
</html>
