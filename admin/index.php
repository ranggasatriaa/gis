
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
  $places2  = $db->getAllPlace();
  $rumahs   = $db->getRumah();
  $masjids  = $db->getAllMasjid();

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
    height: 500px;
    padding: 0 30px;
    display: flex;
    flex-wrap: wrap;
    margin-right: 15px;
    margin-left: 15px;

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
          <li><a href="place.php"> <i class="fa fa-map-o"></i>Place </a></li>
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
        <!-- Dashboard Header Section    -->
        <div id="floating-panel">
          <input id="address" type="textbox" value="Sydney, NSW">
          <input id="submit" type="button" value="Geocode">
        </div>
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
                      $i=1;
                      while ($place2 = $places2->fetch_object()) {
                        // for ($i=1; $i <=$count ; $i++) {
                        ?>
                        <tr>
                          <td>
                            <?= $i; ?>
                          </td>
                          <td>
                            <?= ucwords($place2->place_name); ?>
                          </td>
                          <td>
                            <?= $place2->place_location ?>
                          </td>
                          <td>
                            <?= ((int)$place2->place_category == 0 ? '<p class="text-success">Masjid</p>' : '<p class="text-warning">Rumah</p>' ) ?>
                          </td>
                          <td>
                            <button type="button" data-toggle="modal" data-target="#modalUpgrade" class="btn btn-primary middle btn-sm" data-name="<?=$place2->place_name?>" data-location="<?=$place2->place_location?>" data-category="<?=$place2->place_category?>">Detail</button>
                            <button type="button" data-toggle="modal" data-target="#modalUpgrade" class="btn btn-primary middle btn-sm" data-name="<?=$place2->place_name?>" data-location="<?=$place2->place_location?>" data-category="<?=$place2->place_category?>">Delete</button>
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
        </section>

        <?php include('page-footer.php'); ?>
      </div>
    </div>
  </div>
  <?php include('foot.php'); ?>

  <script>

  // The following example creates complex markers to indicate beaches near
  // Sydney, NSW, Australia. Note that the anchor is set to (0,32) to correspond
  // to the base of the flagpole.

  function initMap() {
    var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 17,
      center: {lat: -7.058202, lng: 110.426634}
    });

    setMarkers(map);
  }

  // Data for the markers consisting of a name, a LatLng and a zIndex for the
  // order in which these markers should display on top of each other.
  var rumahs = [
    <?php
    while($rumah = $rumahs->fetch_object()){
      echo "['".$rumah->place_name."', ".$rumah->place_location.", ".$rumah->place_category."],";
    }
    ?>
  ];
  var masjids = [
    <?php
    while($masjid = $masjids->fetch_object()){
      echo "['".$masjid->place_name."', ".$masjid->place_location.", ".$masjid->place_category."],";
    }
    ?>
  ];

  // ADDS MAEKER TO MAPS.
  function setMarkers(map) {

    //ICON CALLER
    var icon_masjid={
      url: 'https://maps.google.com/mapfiles/kml/shapes/library_maps.png',
      // This marker is 20 pixels wide by 32 pixels high.
      size: new google.maps.Size(32, 32),
      // The origin for this image is (0, 0).
      origin: new google.maps.Point(0, 0),
      // The anchor for this image is the base of the flagpole at (0, 32).
      anchor: new google.maps.Point(0, 16)
    }

    var icon_rumah={
      url: 'https://maps.google.com/mapfiles/kml/shapes/info-i_maps.png',
      // This marker is 20 pixels wide by 32 pixels high.
      size: new google.maps.Size(32, 32),
      // The origin for this image is (0, 0).
      origin: new google.maps.Point(0, 0),
      // The anchor for this image is the base of the flagpole at (0, 32).
      anchor: new google.maps.Point(0, 16)

    }

    //MARKER FOR HOME
    for (var i = 0; i < rumahs.length; i++) {
      var rumah = rumahs[i];
      var marker = new google.maps.Marker({
        position: {lat: rumah[1], lng: rumah[2]},
        map: map,
        icon: icon_rumah,
        title: rumah[0],
      });
    }
    //MARKER FOT MASJID
    for (var i = 0; i < masjids.length; i++) {
      var masjid = masjids[i];
      var marker = new google.maps.Marker({
        position: {lat: masjid[1], lng: masjid[2]},
        map: map,
        icon: icon_masjid,
        title: masjid[0],
      });
    }
  }
  </script>
  <script async defer
  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCqQT371I-5H38pipkOoE3_0eIvcFpho5w&callback=initMap">
  </script>
</body>
</html>
