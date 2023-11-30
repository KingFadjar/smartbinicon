@extends('layouts.app')
@section('content')
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>SmartBin | Rute</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- map leaflet -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
  <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@3.3.4/dist/leaflet-routing-machine.css" />
  <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.css" />
</head>

<body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
  <div class="wrapper">

    <!-- Preloader -->
    <div class="preloader flex-column justify-content-center align-items-center">
      <img class="animation__wobble" src="icon-smartbin.png" alt="SmartBin Logo" height="60" width="60">
    </div>

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-dark">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="{{ route('home') }}" class="nav-link">Beranda</a>
        </li>
      </ul>

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <!-- navbar logout -->
        <li class="nav-item">
          <a class="btn btn-dark" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAwCAYAAABXAvmHAAAACXBIWXMAAAsTAAALEwEAmpwYAAABeklEQVR4nO2ZS0oDQRBAx4WCuosrjQfQoyQIEVFc6AVEd4KXiAcRl/EMQhD1BH5w4gfRlZ/VCE8aWmzHWYShqrVJvQNU1Zuurm56sswwDONfA0wAO0AfeEOGd+AU2AOmNYufA87R5RJY1Pry2sV/kQMz0gKubWKyLy3gej6k51pKKHYTOCjFv5OIHSZ5LSVoCsefBB6C+HkmnOAHosG/c7SBAXANtJITUMUERmUFgDXg2U0hYDm1TTwGPAVpCmA9tRV4LKWSkYgosOKLlpWIOYWA1QqJD2AzmXMAaYlhBPxJ6k5RTYpa02lIgVviMNAScPeYGORaAi3gKtkWUjiRi4pNvFE3YDQBpIuPKQB0kj7I+D0IkrtK3IsX/wctlPtp1pEMHG0Tq2ACo7ACwJLfxO5C2JYO/pL6w1a/JHAkJQHMA4faT4vbxKWr8bx+Fqn4G6AhKuAlZv2fFE0ugAXx4gOJcWALOK54sa6L+1V1AuwCU2rFG4ZhZNp8AgP1WnQOYyj4AAAAAElFTkSuQmCC" width="20px"></img>
            {{ __('Logout') }}
          </a>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
          </form>
        </li>
      </ul>
    </nav>
    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="{{ route('home') }}" class="brand-link">
        <img src="icon-smartbin.png" alt="SmartBin Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">SmartBin</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">

        <!-- SidebarSearch Form -->
        <div class="form-inline mt-3">
          <div class="input-group" data-widget="sidebar-search">
            <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
              <button class="btn btn-sidebar">
                <i class="fas fa-search fa-fw"></i>
              </button>
            </div>
          </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
            <li class="nav-item menu-open">
              <a href="#" class="nav-link active">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                  Daftar Menu
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{ route('get-lokasi') }}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Lokasi</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('get-rute') }}" class="nav-link active">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Rute</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('get-centimeter-data') }}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Kapasitas Sampah</p>
                  </a>
                </li>
              </ul>
            </li>
          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>

    <!-- map peta -->
    <style>
      #map {
        height: 100vh;
        width: 100%;
      }
      .leaflet-routing-container {
      color: black !important;
    }
    
    </style>
    <div id="map"></div>
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.js"></script>
    <script src="https://unpkg.com/leaflet-routing-machine@3.3.4/dist/leaflet-routing-machine.css"></script>
    <script>
      var map = L.map('map').setView([-6.235279747898276, 106.8208198373647], 13);

      var osm = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
      });
      osm.addTo(map);

      var redMarkerIcon = L.icon({
        iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png',
        shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/images/marker-shadow.png',
        iconSize: [25, 41],
        iconAnchor: [12, 41],
        popupAnchor: [1, -34],
        shadowSize: [41, 41]
      });

      var coordinates = [
        [-6.244528, 106.832361],
        [-6.245111, 106.832306],
        [-6.245233, 106.831592],
        [-6.245192, 106.831250],
        [-6.245311, 106.830833],
        [-6.245233, 106.830694],
        [-6.244889, 106.830750],
        [-6.244500, 106.830917],
        [-6.244417, 106.830917],
        [-6.244306, 106.830944],
        [-6.244306, 106.830833],
        [-6.243806, 106.830750],
        [-6.243750, 106.830806],
        [-6.243667, 106.830750],
        [-6.243389, 106.830694],
        [-6.243333, 106.830750],
        [-6.243194, 106.830694],
        [-6.242972, 106.830583],
        [-6.242972, 106.830750],
        [-6.242972, 106.830917],
        [-6.242972, 106.831639],
        [-6.242972, 106.831694],
        [-6.242972, 106.831889],
        [-6.242972, 106.832194],
        [-6.242972, 106.832528],
        [-6.242972, 106.882333],
        [-6.242972, 106.882778],
        [-6.242972, 106.882639],
        [-6.242972, 106.882917],
        [-6.242972, 106.882222],
        [-6.242972, 106.882667],
        [-6.242972, 106.882250],
        [-6.242972, 106.882222],
        [-6.242972, 106.882361],
        [-6.242972, 106.881917]
      ];

      var markers = [];
      for (var i = 0; i < coordinates.length; i++) {
        var marker = L.marker(coordinates[i], {
          icon: redMarkerIcon
        }).bindPopup('Titik ' + (i + 1));
        markers.push(marker);
        marker.addTo(map);
      }

      var routingControl = L.Routing.control({
        waypoints: [
          L.latLng(-6.244528, 106.832361),
          L.latLng(-6.245111, 106.832306),
          L.latLng(-6.245233, 106.831592),
          L.latLng(-6.245192, 106.831250),
          L.latLng(-6.245311, 106.830833),
          L.latLng(-6.245233, 106.830694),
          L.latLng(-6.244889, 106.830750),
          L.latLng(-6.244500, 106.830917),
          L.latLng(-6.244417, 106.830917),
          L.latLng(-6.244306, 106.830944),
          L.latLng(-6.244306, 106.830833),
          L.latLng(-6.243806, 106.830750),
          L.latLng(-6.243750, 106.830806),
          L.latLng(-6.243667, 106.830750),
          L.latLng(-6.243389, 106.830694),
          L.latLng(-6.243333, 106.830750),
          L.latLng(-6.243194, 106.830694),
          L.latLng(-6.242972, 106.830583),
          L.latLng(-6.242972, 106.830750),
          L.latLng(-6.242972, 106.830917),
          L.latLng(-6.242972, 106.831639),
          L.latLng(-6.242972, 106.831694),
          L.latLng(-6.242972, 106.831889),
          L.latLng(-6.242972, 106.832194),
          L.latLng(-6.242972, 106.832528),
          L.latLng(-6.242972, 106.882333),
          L.latLng(-6.242972, 106.882778),
          L.latLng(-6.242972, 106.882639),
          L.latLng(-6.242972, 106.882917),
          L.latLng(-6.242972, 106.882222),
          L.latLng(-6.242972, 106.882667),
          L.latLng(-6.242972, 106.882250),
          L.latLng(-6.242972, 106.882222),
          L.latLng(-6.242972, 106.882361),
          L.latLng(-6.242972, 106.881917)
        ],
        routeWhileDragging: true
      }).addTo(map);

      var OpenStreetMap_BZH = L.tileLayer('https://tile.openstreetmap.bzh/br/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Tiles courtesy of <a href="http://www.openstreetmap.bzh/" target="_blank">Breton OpenStreetMap Team</a>',
        bounds: [
          [46.2, -5.5],
          [50, 0.7]
        ]
      });
      OpenStreetMap_BZH.addTo(map);

      var googleStreets = L.tileLayer('http://{s}.google.com/vt?lyrs=m&x={x}&y={y}&z={z}', {
        maxZoom: 20,
        subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
      });
      googleStreets.addTo(map);

      var googleSat = L.tileLayer('http://{s}.google.com/vt?lyrs=s&x={x}&y={y}&z={z}', {
        maxZoom: 20,
        subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
      });
      googleSat.addTo(map);

      var baseLayers = {
        "OpenStreetMap": osm,
        "Satelite": googleSat,
        "Google Map": googleStreets,
      };

      var overlays = {};
      for (var i = 0; i < markers.length; i++) {
        overlays['Titik ' + (i + 1)] = markers[i];
      };

      L.control.layers(baseLayers, overlays).addTo(map);
    </script>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->

  </div>
  <!-- ./wrapper -->

  <!-- REQUIRED SCRIPTS -->
  <!-- jQuery -->
  <script src="plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap -->
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- overlayScrollbars -->
  <script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
  <!-- AdminLTE App -->
  <script src="dist/js/adminlte.js"></script>

  <!-- PAGE PLUGINS -->
  <!-- jQuery Mapael -->
  <script src="plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
  <script src="plugins/raphael/raphael.min.js"></script>
  <script src="plugins/jquery-mapael/jquery.mapael.min.js"></script>
  <script src="plugins/jquery-mapael/maps/usa_states.min.js"></script>
  <!-- ChartJS -->
  <script src="plugins/chart.js/Chart.min.js"></script>

  <!-- AdminLTE for demo purposes -->
  <script src="dist/js/demo.js"></script>
  <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
  <script src="dist/js/pages/dashboard2.js"></script>
</body>

</html>
@endsection