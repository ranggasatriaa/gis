
<?php
session_start();
require_once('../includes/request-key.php');
require_once('../includes/db-helper.php');

if(!isset($_SESSION[RequestKey::$USER_ID])) {
  header('Location: ../.');
}
if ($_SESSION[RequestKey::$USER_LEVEL] != 1){
  header('Location: ../unauthorize.php');
}
else {
  $db = new DBHelper();
  $side_bar = 1;

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
      <?php include('side-navbar.php') ?>
      <div class="content-inner">
        <!-- Page Header-->
        <header class="page-header">
          <div class="container-fluid">
            <h2 class="no-margin-bottom">Dashboard</h2>
          </div>
        </header>
        <section class="charts">
          <div class="container-fluid">
            <div class="row">
              <div class="col-lg-6">
                <div class="pie-chart-example card">
                  <div class="card-header">
                    <h3>Umur</h3>
                  </div>
                  <div class="card-body">
                    <canvas id="chartAge"></canvas>
                  </div>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="pie-chart-example card">
                  <div class="card-header">
                    <h3> Pendidikan</h3>
                  </div>
                  <div class="card-body">
                    <canvas id="chartEducation"></canvas>
                  </div>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="pie-chart-example card">
                  <div class="card-header">
                    <h3> Agama</h3>
                  </div>
                  <div class="card-body">
                    <canvas id="chartReligion"></canvas>
                  </div>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="pie-chart-example card">
                  <div class="card-header">
                    <h3> Intensitas Sholat</h3>
                  </div>
                  <div class="card-body">
                    <canvas id="chartSholat"></canvas>
                  </div>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="pie-chart-example card">
                  <div class="card-header">
                    <h3> Kemampuan Membaca Al-Quran</h3>
                  </div>
                  <div class="card-body">
                    <canvas id="chartMengaji"></canvas>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </section>
        <div class="container-fluid">
          <div class="row">
            <div class="col-lg-12 no-padding  ">
              <div class="card no-margin">
                <div class="card-header">
                  Peta
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- Dashboard Header Section    -->
        <div id="map"></div>
        <?php include('page-footer.php'); ?>
      </div>
    </div>
  </div>
  <?php include('foot.php'); ?>

  <script>


  // ------------------------------------------------------- //
  // Pie Chart Umur
  // ------------------------------------------------------ //
  var chartAge = new Chart($('#chartAge'), {
    type: 'pie',
    data: {
      labels: [
        "Balita",
        "Anak-anak",
        "Remaja Awal",
        "Remaja Akhir",
        "Dewasa Awaal",
        "Dewasa Akhir",
        "Lansia Awal",
        "Lansia Akhir",
        "Manula"
      ],
      datasets: [
        {
          data: [<?=$db->countAge(1)?>,<?=$db->countAge(2)?>,<?=$db->countAge(3)?>,<?=$db->countAge(4)?>,<?=$db->countAge(5)?>,<?=$db->countAge(6)?>,<?=$db->countAge(7)?>,<?=$db->countAge(8)?>,<?=$db->countAge(9)?>],
          borderWidth: 0,
          backgroundColor: [
            "#d5e9ca",
            "#9ed5cd",
            "#69c0d1",
            "#44a7cb",
            "#3984b6",
            "#2e62a1",
            "#233f8c",
            "#192473",
            "#121850"

          ],
          hoverBackgroundColor: [
            "#d5e9ca",
            "#9ed5cd",
            "#69c0d1",
            "#44a7cb",
            "#3984b6",
            "#2e62a1",
            "#233f8c",
            "#192473",
            "#121850"
          ]
        }
      ]
    }
  });

  var chartAge = {
    responsive: true
  };

  // ------------------------------------------------------- //
  // Pie Chart EDUCATION
  // ------------------------------------------------------ //
  var chartEducation = new Chart($('#chartEducation'), {
   type: 'pie',
   data: {
     labels: [
       "Tidak sekolah",
       "SD/MI",
       "SMP/STM",
       "SMA/MA",
       "SMK",
       "Diploma",
       "Sarjana (S1)",
       "Magister (S2)",
       "Doktor (S3)"
     ],
     datasets: [
       {
         data: [<?=$db->countEducation(0)?>,<?=$db->countEducation(1)?>,<?=$db->countEducation(2)?>,<?=$db->countEducation(3)?>,<?=$db->countEducation(4)?>,<?=$db->countEducation(5)?>,<?=$db->countEducation(6)?>,<?=$db->countEducation(7)?>,<?=$db->countEducation(8)?>],
         borderWidth: 0,
         backgroundColor: [
           "#d5e9ca",
           "#9ed5cd",
           "#69c0d1",
           "#44a7cb",
           "#3984b6",
           "#2e62a1",
           "#233f8c",
           "#192473",
           "#121850"

         ],
         hoverBackgroundColor: [
           "#d5e9ca",
           "#9ed5cd",
           "#69c0d1",
           "#44a7cb",
           "#3984b6",
           "#2e62a1",
           "#233f8c",
           "#192473",
           "#121850"
         ]
       }
     ]
   }
  });

  var chartEducation = {
   responsive: true
  };

  // ------------------------------------------------------- //
  // Pie Chart RELIGION
  // ------------------------------------------------------ //
  var chartReligion = new Chart($('#chartReligion'), {
   type: 'pie',
   data: {
     labels: [
       "Islam",
       "Kristen",
       "Katolok",
       "Budha",
       "Hindu",
       "Lainnya"
     ],
     datasets: [
       {
         data: [<?=$db->countReligion(1)?>,<?=$db->countReligion(2)?>,<?=$db->countReligion(3)?>,<?=$db->countReligion(4)?>,<?=$db->countReligion(5)?>,<?=$db->countReligion(6)?>],
         borderWidth: 0,
         backgroundColor: [
           "#9ed5cd",
           "#69c0d1",
           "#44a7cb",
           "#3984b6",
           "#2e62a1",
           "#192473"
         ],
         hoverBackgroundColor: [
           "#9ed5cd",
           "#69c0d1",
           "#44a7cb",
           "#3984b6",
           "#2e62a1",
           "#192473"
         ]
       }
     ]
   }
  });

  var chartReligion = {
   responsive: true
  };
  // ------------------------------------------------------- //
  // Pie Chart Sholat
  // ------------------------------------------------------ //
  var chartSholat = new Chart($('#chartSholat'), {
   type: 'pie',
   data: {
     labels: [
       "TIdak Sholat",
       "5 Waktu di Masjid",
       "5 waktu di rumah",
       "Tidak 5 waktu di masjid",
       "Sholat Jumat Saja",
       "Sholat Hari Raya Saja",
     ],
     datasets: [
       {
         data: [<?=$db->countSholat(0)?>,<?=$db->countSholat(1)?>,<?=$db->countSholat(2)?>,<?=$db->countSholat(3)?>,<?=$db->countSholat(4)?>,<?=$db->countSholat(5)?>],
         borderWidth: 0,
         backgroundColor: [
           "#9ed5cd",
           "#69c0d1",
           "#44a7cb",
           "#3984b6",
           "#2e62a1",
           "#192473"
         ],
         hoverBackgroundColor: [
           "#9ed5cd",
           "#69c0d1",
           "#44a7cb",
           "#3984b6",
           "#2e62a1",
           "#192473"

         ]
       }
     ]
   }
  });

  var chartSholat = {
   responsive: true
  };

  // ------------------------------------------------------- //
  // Pie Chart Mengaji
  // ------------------------------------------------------ //
  var chartMengaji = new Chart($('#chartMengaji'), {
   type: 'pie',
   data: {
     labels: [
       "Tidak Bisa",
       "Kurang Lancar",
       "Lancar Membaca",
       "Hafal Al-Quran"
     ],
     datasets: [
       {
         data: [<?=$db->countMengaji(1)?>,<?=$db->countMengaji(2)?>,<?=$db->countMengaji(3)?>,<?=$db->countMengaji(4)?>,<?=$db->countMengaji(5)?>],
         borderWidth: 0,
         backgroundColor: [
           '#b7dfcb',
           "#5abad1",
           "#3984b6",
           "#264992",
           "#151e5e"

         ],
         hoverBackgroundColor: [
           '#b7dfcb',
           "#5abad1",
           "#3984b6",
           "#264992",
           "#151e5e"
         ]
       }
     ]
   }
  });

  var chartMengaji = {
   responsive: true
  };

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
      url: '../img/masjid.png',
      // This marker is 20 pixels wide by 32 pixels high.
      size: new google.maps.Size(32, 32),
      // The origin for this image is (0, 0).
      origin: new google.maps.Point(0, 0),
      // The anchor for this image is the base of the flagpole at (0, 32).
      anchor: new google.maps.Point(16, 32)
    }

    var islam_icon={
      url: '../img/islam_icon.png',
      size: new google.maps.Size(32, 32),
      origin: new google.maps.Point(0, 0),
      anchor: new google.maps.Point(16, 32)
    }

    var kristen_icon={
      url: '../img/kristen_icon.png',
      size: new google.maps.Size(32, 32),
      origin: new google.maps.Point(0, 0),
      anchor: new google.maps.Point(16, 32)
    }
    var katolik_icon={
      url: '../img/katolik_icon.png',
      size: new google.maps.Size(32, 32),
      origin: new google.maps.Point(0, 0),
      anchor: new google.maps.Point(16, 32)
    }
    var budha_icon={
      url: '../img/budha_icon.png',
      size: new google.maps.Size(32, 32),
      origin: new google.maps.Point(0, 0),
      anchor: new google.maps.Point(16, 32)
    }
    var hindu_icon={
      url: '../img/hindu_icon.png',
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
      var content = "<div style='width:200px;min-height:40px'><h3>Rumah Keluarga" + rumah[0] + "</h3><br/><a href='family/detail_family.php?place-id="+rumah[3]+"'>Read More</a></div>"

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

      var content = "<div style='width:200px;min-height:40px'><h3>" + masjid[0] + "</h3><p>"+masjid[4]+"...</p><a href='masjid/detail_masjid.php?place-id="+masjid[3]+"'>Read More</a></div>"

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
