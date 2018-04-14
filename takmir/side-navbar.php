<!-- Side Navbar -->
<nav class="side-navbar">
  <!-- Sidebar Header-->
  <div class="sidebar-header d-flex align-items-center">
    <div class="avatar"><img src="../img/no_image_image.png" alt="..." class="img-fluid rounded-circle" style="height:55px; width: 55px; object-fit: contain;"></div>
    <div class="title">
      <h1 class="h4">TAKMIR</h1>
    </div>
  </div>
  <!-- Sidebar Navidation Menus--><span class="heading">Main</span>
  <ul class="list-unstyled">
    <li <?=$side_bar == 1 ? "class='active'" : ""?> ><a href="."> <i class="icon-home"></i>Dashboard </a></li>
    <li <?=$side_bar == 2 ? "class='active'" : ""?> ><a href="place.php"> <i class="fa fa-map-o"></i>Place </a></li>
    <li <?=$side_bar == 3 ? "class='active'" : ""?> ><a href="people/"> <i class="fa fa-group"></i>Masyarakat </a></li>
    <li <?=$side_bar == 4 ? "class='active'" : ""?> ><a href="profil.php"> <i class="fa fa-user"></i>Profil </a></li>
  </ul>
</nav>
