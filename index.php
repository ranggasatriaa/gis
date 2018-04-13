
<?php
session_start();
require_once('includes/request-key.php');
require_once('includes/db-helper.php');

if(isset($_SESSION[RequestKey::$USER_ID])) {
  header('Location: admin/.');
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
    height: 450px;
    /* padding: 0 30px; */
    display: flex;
    flex-wrap: wrap;
    margin-bottom: 30px;

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

    <div class="row">

      <div class="col-lg-12">
        <!-- Page Header-->
        <header class="page-header">
          <div class="container-fluid">
            <h2 class="no-margin-bottom">Dashboard</h2>
          </div>
        </header>
        <section class="projects no-padding-top ">
          <div  id="map"></div>
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
    var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 17,
      styles: styles,
      center: {lat: -7.058202, lng: 110.426634}
    });

    setMarkers(map);
  }

  // Data for the markers consisting of a name, a LatLng and a zIndex for the
  // order in which these markers should display on top of each other.
  var rumahs = [
    <?php
    while($rumah = $rumahs->fetch_object()){
      $family = $db->getFamilyLeader($rumah->place_id);
      echo "['".ucwords($rumah->place_name)."', ".$rumah->place_location.", ".$rumah->place_id.",".$family->family_religion."],";
    }
    ?>
  ];
  var masjids = [
    <?php
    while($masjid = $masjids->fetch_object()){
      $masjidDetail = $db->getMasjidByPlaceId($masjid->place_id);
      echo "['".ucwords($masjid->place_name)."', ".$masjid->place_location.", ".$masjid->place_id.", '". implode(' ', array_slice(explode(' ', $masjidDetail->masjid_history), 0, 10))."'],";
    }
    ?>
  ];

  // ADDS MAEKER TO MAPS.
  function setMarkers(map) {

    //ICON CALLER
    var masjid_icon={
      // url: 'https://maps.google.com/mapfiles/kml/shapes/library_maps.png',
      url: 'img/masjid.png',
      // This marker is 20 pixels wide by 32 pixels high.
      size: new google.maps.Size(32, 32),
      // The origin for this image is (0, 0).
      origin: new google.maps.Point(0, 0),
      // The anchor for this image is the base of the flagpole at (0, 32).
      anchor: new google.maps.Point(16, 32)
    }

    var islam_icon={
      url: 'img/islam_icon.png',
      size: new google.maps.Size(32, 32),
      origin: new google.maps.Point(0, 0),
      anchor: new google.maps.Point(16, 32)
    }

    var kristen_icon={
      url: 'img/kristen_icon.png',
      size: new google.maps.Size(32, 32),
      origin: new google.maps.Point(0, 0),
      anchor: new google.maps.Point(16, 32)
    }
    var katolik_icon={
      url: 'img/katolik_icon.png',
      size: new google.maps.Size(32, 32),
      origin: new google.maps.Point(0, 0),
      anchor: new google.maps.Point(16, 32)
    }
    var budha_icon={
      url: 'img/budha_icon.png',
      size: new google.maps.Size(32, 32),
      origin: new google.maps.Point(0, 0),
      anchor: new google.maps.Point(16, 32)
    }
    var hindu_icon={
      url: 'img/hindu_icon.png',
      size: new google.maps.Size(32, 32),
      origin: new google.maps.Point(0, 0),
      anchor: new google.maps.Point(16, 32)
    }

    //MARKER FOR HOME
    var infowindow = new google.maps.InfoWindow()
    for (var i = 0; i < rumahs.length; i++) {
      var rumah = rumahs[i];
      //change logo
      if (rumah[4] == 1) {
        var religion = islam_icon;
      }else if (rumah[4] == 2) {
        var religion = kristen_icon;
      }else if (rumah[4] == 3) {
        var religion = katolik_icon;
      }else if (rumah[4] == 4) {
        var religion = budha_icon;
      }else if (rumah[4] == 5) {
        var religion = hindu_icon;
      }
      var marker = new google.maps.Marker({
        position: {lat: rumah[1], lng: rumah[2]},
        map: map,
        icon: religion,
        title: rumah[0],
      });
      var content = "<div style='width:200px;min-height:40px'><h3>Rumah Keluarga " + rumah[0] + "</h3><br/><a href='user/detail_family.php?place-id="+rumah[3]+"'>Read More</a></div>"

      google.maps.event.addListener(marker,'click', (function(marker,content,infowindow){
        return function() {
          infowindow.setContent(content);
          infowindow.open(map,marker);
        };
      })(marker,content,infowindow));
      marker.addListener('click', function() {
        map.setZoom(19);
        map.setCenter(marker.getPosition());
      });
    }

    //MARKER FOT MASJID
    for (var i = 0; i < masjids.length; i++) {
      var masjid = masjids[i];
      var marker = new google.maps.Marker({
        position: {lat: masjid[1], lng: masjid[2]},
        map: map,
        icon: masjid_icon,
        title: masjid[0],
      });

      var content = "<div style='width:200px;min-height:40px'><h3>" + masjid[0] + "</h3><p>"+masjid[4]+"...</p><a href='user/detail_masjid.php?place-id="+masjid[3]+"'>Read More</a></div>"


      google.maps.event.addListener(marker,'click', (function(marker,content,infowindow){
        return function() {
          infowindow.setContent(content);
          infowindow.open(map,marker);
        };
      })(marker,content,infowindow));
      marker.addListener('click', function() {
        map.setZoom(19);
        map.setCenter(marker.getPosition());
      });
    }
  }

  </script>
  <script async defer
  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCqQT371I-5H38pipkOoE3_0eIvcFpho5w&callback=initMap">
  </script>
</body>
</html>
