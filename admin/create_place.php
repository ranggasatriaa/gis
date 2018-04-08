
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
  $masjids  = $db->getPlaceMasjid();
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
  #coords {
    background-color: black;
    color: white;
    padding: 5px;
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
          <div class="avatar"><img src="../img/no_image_image.png" alt="..." class="img-fluid rounded-circle" style="height:55px; width: 55px; object-fit: contain;"></div>
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
          <input id="cek" type="text">
          <!-- <div id='map_canvas'></div> -->
          <div id="current">Nothing yet...</div>

          <!-- </div> -->
        </header>
        <!-- Dashboard Header Section    -->
        <div id="map"></div>
        <div id="coords"></div>
        <?php include('page-footer.php'); ?>
      </div>
    </div>
  </div>
  <?php include('foot.php'); ?>

  <script>

  // The following example creates complex markers to indicate beaches near
  // Sydney, NSW, Australia. Note that the anchor is set to (0,32) to correspond
  // to the base of the flagpole.
  var styles =[
    {
      featureType: "poi",
      elementType: "labels",
      stylers: [
        { visibility: "off" }
      ]
    }
  ];

  function initMap() {
    // var map = new google.maps.Map(document.getElementById('map'), {
    //   zoom: 17,
    //   styles: styles,
    //   center: {lat: -7.058202, lng: 110.426634}
    // });
    //
    // setMarkers(map);

    // google.maps.event.addListener(map, "click", function (e) {
    //
    //   //lat and lng is available in e object
    //   var latLng = e.latLng;
    //
    // });

    var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 17,
      center: new google.maps.LatLng( -7.058202, 110.426634),
      mapTypeId: google.maps.MapTypeId.ROADMAP
    });

    var myMarker = new google.maps.Marker({
      position: new google.maps.LatLng(-7.058202, 110.426634),
      draggable: true
    });

    google.maps.event.addListener(myMarker, 'dragend', function(evt){
      document.getElementById('current').innerHTML = '<p>Marker dropped: Current Lat: ' + evt.latLng + ' Current Lng: ' + evt.latLng.lng()+ '</p>';
      document.getElementById('cek').value= evt.latLng.lat()+", "+evt.latLng.lng() ;
    });

    google.maps.event.addListener(myMarker, 'dragstart', function(evt){
      document.getElementById('current').innerHTML = '<p>Currently dragging marker...</p>';
    });
    map.setCenter(myMarker.position);
    myMarker.setMap(map);
  }





  </script>
  <script async defer
  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCqQT371I-5H38pipkOoE3_0eIvcFpho5w&callback=initMap">
  </script>
</body>
</html>
