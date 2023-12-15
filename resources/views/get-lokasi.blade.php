@extends('layouts.app')
@section('content')
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>SmartBin | Lokasi</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">
  <!-- map leaflet -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />

</head>

<body class="hold-transition sidebar-mini layout-fixed dark-mode" data-panel-auto-height-mode="height">
  <div class="wrapper">

    <!-- Preloader -->
    <div class="preloader flex-column justify-content-center align-items-center">
      <img class="animation__shake" src="icon-smartbin.png" alt="SmartBin Logo" height="60" width="60">
    </div>

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-dark">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="{{ route('home') }}" class="nav-link">Beranda</a>
        </li>
      </ul>

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <!-- navbar logout -->
        <li class="nav-item">
          <a class="btn btn-danger" href="{{ route('logout') }}" onclick="event.preventDefault();
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
                  <a href="{{ route('get-lokasi') }}" class="nav-link active">
                  <img width="25" height="25" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAwCAYAAABXAvmHAAAACXBIWXMAAAsTAAALEwEAmpwYAAABz0lEQVR4nO3YzYtOURzA8RPFJAtJIVlIXqJsLFBjYScWpCwslJ2XjZ2dUhaslJUUq1nZWGnKRpGysFHKRpmiyZS8phhm5qNbtzw9YZ7nnnvuPY/u9y/4fm/3nN85J4SOjo6OVGAzxsMogQ24hfd+8xHrQ65gBS7jtb/zMOQEluA0nmPB4kyFHMBBPMIPw3G37cU4gc+qs6tp6dW4hhnxvGtKehnO4cWA//Wg3EgtfgRPMC8Na1NI78UkZqVlqk7pTbjZN2RSczFWelU5ZN5onnmMxchfrXkxDsuzGPmT2udUVfndFSZl3czGfP1iobbNg5iA223b40BMwD78bFH+S2X5noj9xS7QUsCd6ICeM/txvGo4YEctAX2HtPPl1S41M7XK/+GIXAy3bwkDricL6AnZWG61czXLL2BN8oCekJ24V2PAy8bk+0IOYbqGgAutBJQR2/A1Qn6u2CxaCygjLkUEPG1VvgxYibcVA06EHMDZCvLfQy5gafkqMQz3Q07g2JAB4yE38HhA+U8hR7BnwPv0RMiV4kF2gIAtIVewdZG79XTIneJd8x8BZ0LuYF1xRewTL9bGlTAq4HDxRF7Kf8DRMGpgDNuxvG2Xjo7/iV8o958YCuMy6QAAAABJRU5ErkJggg=="/>
                    <p>Lokasi</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('get-rute') }}" class="nav-link">
                  <img width="25" height="25" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyCAYAAAAeP4ixAAAACXBIWXMAAAsTAAALEwEAmpwYAAACxUlEQVR4nO2Yu49NQRzHZ7FIECFeHSJLIYhC9rrWo1LQildCFB6F6GhWxKNQYCMi/gBEsSHRUCGLpZFNUCg8glVZiY2VEGL5yMjv2FnnfWfOnXvjfLsz8zu/7/nM+c3jHKVKlSpVqtT/JKAF6CG7elUjClhJPt1XjSjgrDzgGdXkZdUvIO2qWQVUBeKdhlLNKoooK+Ah/lRxCeJL/UFZpQxmT6byw5/+lpWTN0dYVevXPDr/qrSHCxpU+N4u6eqqBaTDMcjqpLJKAalExWcFqYdGrVYJIC3A20zl5QmkPQtIrvLyABEqEwc5H+RJUnU00UMj6wCEPEk6HE30im8QF4o8W7lIrIBb1E+RE9ZFYiWJ5gGbgdPAXeAzDXi2In5zJe6GscBiYBdwAXgEfLeESN/UUqTnaS6QmCTjBG4ncA7oA37m3QSBLZYDYg0yJqJtCrAOOARcNXbh2LKSOK8gQ3KkPgVsAubGxM0CNgLHgJvAB+COHDcmA198g0RpALgBHAU2ADNTcug3V4hUBoBW4ESOnG+AbuAgsBaYqgHl+ocXEGCi/p8kscPANWA/sB04DDx2/DzDtXqkgVyWuFfAkoh+Xff7HCzN1h4qAWKFxAwC81OAtZGNrD1Uwo2XJKbTaFsjr3pIltEZxqg9sQCx9lAJIM8kZqFcT5eRM9VtxB+xALH2UAkgXyVmglyvj7h/0IjfYQFi69GbBKI3Mq3Zct0G/PonQZ8Rf0DazscmDXsMFO2hZDfW2ma0HTeMPurTqNF3Xdp3N5KHMlaJp8B4o71NSmCa0bZc9oBvweTM6LGnaA+lEwMvxUjvJ60xcQuA1xJ3MrPBiMfzIj3+CFhmfGTppW8rMEceYJGsIp+k/14wafMIWCpLbWEeJswLknUFmFSTwQhMoR6BkR6dvcBt4L0cF/S3x0X9p8QqeR09SpUqpZpfvwEgyUkisbZ/cwAAAABJRU5ErkJggg=="/>
                    <p>Rute
                    <i class="right fas fa-angle-left"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    <li class="nav-item ml-3">
                      <a href="{{ route('get-rute') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Nama Rute</p>
                      </a>
                    </li>
                    <li class="nav-item ml-3">
                      <a href="{{ route('get-rute') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Smartbin Visit</p>
                      </a>
                    </li>
                    <li class="nav-item ml-3">
                      <a href="{{ route('get-rute') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Jadwal</p>
                      </a>
                    </li>
                  </ul>
                </li>
                <li class="nav-item">
                  <a href="{{ route('get-centimeter-data') }}" class="nav-link">
                  <img width="25" height="25" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyCAYAAAAeP4ixAAAACXBIWXMAAAsTAAALEwEAmpwYAAABy0lEQVR4nM3ZvyuFURwG8JdikWKg5A+gpCSWy01JYWdgkJKJgYFBJoZLMjDekpKSiUFKSvJbDAwyMRBuYr9F99HpHnWHy33vvef7fN9nPJ33POfznuGt93ieowAoBjAP4BWZ8wJgzjzjBS1IbizbRLygBcm3bBLyMbf192S8oAU2UvNpCTQEwCmCk5N8IMcITo5cnMyjIuAhb0AK5FwRcuYSsq0I2XIJifooDKV8H/yOt/hYN+oSMpupLWVuXuNpMuMSMgo9yIhLSK8ipMclpE0REnYJqVWE1LiElCtCylxCCgDEFSBx0+0MYgufFSBPThG28FoBciUB2VWA7EhAVhUgK/SfC0KQiARkXAEyJgHpV4D0SUA6FCDtEpB6BUidBKRSAVIhASkE8EWEfJtO5xBbGiNC3kQQtvSWCLmRhOwTIXuSkHUiZE0SskiELEhCJomQCUnIIBEyIAnpJkI6JSGNREiDJKSaCKmShBQBSBAgCdMlBrHFnwTIhyjCFt8TIHcMyCEBcsCAbBIgGwzI8h/l5vYpnOV4upsskyUGZBrymWJAhgmQIQakiwDpZEBKAbwLImIASsQhFtMM4PK/nxE5xKx1AaApl039ADHK3/YJmOgMAAAAAElFTkSuQmCC"/>
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
        height: 92vh;
        width: 100%;
      }

      .legend {
        background-color: #343a40;
        padding: 10px;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        position: absolute;
        bottom: 20px;
        right: 20px;
        z-index: 1000;
      }

      .legend-item {
        display: flex;
        align-items: center;
        margin-bottom: 5px;
      }

      .legend-icon {
        width: 20px;
        height: 20px;
        margin-right: 8px;
      }
    </style>
    <div id="map"></div>

    <!-- Legenda -->
    <div class="legend">
      <div class="legend-item">
        <img class="legend-icon" src="https://img.icons8.com/doodle/48/cottage--v1.png">
        Lokasi SmartBin
      </div>
    </div>

    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
    <script>
      var map = L.map('map').setView([-6.244528, 106.832361], 13);

      var osm = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
      });
      osm.addTo(map);

      var homeIcon = L.icon({
        iconUrl: 'https://img.icons8.com/doodle/48/cottage--v1.png',
        iconSize: [40, 45],
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
          icon: homeIcon
        }).bindPopup('Titik ' + (i + 1));
        marker.addTo(map);
      }

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

      var overlays = {
        "Marker": markers,
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

  <!-- jQuery -->
  <script src="plugins/jquery/jquery.min.js"></script>
  <!-- jQuery UI 1.11.4 -->
  <script src="plugins/jquery-ui/jquery-ui.min.js"></script>
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <script>
    $.widget.bridge('uibutton', $.ui.button)
  </script>
  <!-- Bootstrap 4 -->
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- ChartJS -->
  <script src="plugins/chart.js/Chart.min.js"></script>
  <!-- Sparkline -->
  <script src="plugins/sparklines/sparkline.js"></script>
  <!-- JQVMap -->
  <script src="plugins/jqvmap/jquery.vmap.min.js"></script>
  <script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
  <!-- jQuery Knob Chart -->
  <script src="plugins/jquery-knob/jquery.knob.min.js"></script>
  <!-- daterangepicker -->
  <script src="plugins/moment/moment.min.js"></script>
  <script src="plugins/daterangepicker/daterangepicker.js"></script>
  <!-- Tempusdominus Bootstrap 4 -->
  <script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
  <!-- Summernote -->
  <script src="plugins/summernote/summernote-bs4.min.js"></script>
  <!-- overlayScrollbars -->
  <script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
  <!-- AdminLTE App -->
  <script src="dist/js/adminlte.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="dist/js/demo.js"></script>
  <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
  <script src="dist/js/pages/dashboard.js"></script>
</body>

</html>
@endsection