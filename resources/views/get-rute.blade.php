@extends('layouts.app')
@section('content')
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

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
                  <a href="{{ route('get-lokasi') }}" class="nav-link">
                    <img width="25" height="25" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAwCAYAAABXAvmHAAAACXBIWXMAAAsTAAALEwEAmpwYAAABz0lEQVR4nO3YzYtOURzA8RPFJAtJIVlIXqJsLFBjYScWpCwslJ2XjZ2dUhaslJUUq1nZWGnKRpGysFHKRpmiyZS8phhm5qNbtzw9YZ7nnnvuPY/u9y/4fm/3nN85J4SOjo6OVGAzxsMogQ24hfd+8xHrQ65gBS7jtb/zMOQEluA0nmPB4kyFHMBBPMIPw3G37cU4gc+qs6tp6dW4hhnxvGtKehnO4cWA//Wg3EgtfgRPMC8Na1NI78UkZqVlqk7pTbjZN2RSczFWelU5ZN5onnmMxchfrXkxDsuzGPmT2udUVfndFSZl3czGfP1iobbNg5iA223b40BMwD78bFH+S2X5noj9xS7QUsCd6ICeM/txvGo4YEctAX2HtPPl1S41M7XK/+GIXAy3bwkDricL6AnZWG61czXLL2BN8oCekJ24V2PAy8bk+0IOYbqGgAutBJQR2/A1Qn6u2CxaCygjLkUEPG1VvgxYibcVA06EHMDZCvLfQy5gafkqMQz3Q07g2JAB4yE38HhA+U8hR7BnwPv0RMiV4kF2gIAtIVewdZG79XTIneJd8x8BZ0LuYF1xRewTL9bGlTAq4HDxRF7Kf8DRMGpgDNuxvG2Xjo7/iV8o958YCuMy6QAAAABJRU5ErkJggg==" />
                    <p>Lokasi</p>
                  </a>
                </li>
                <li class="nav-item menu-open">
                  <a href="#" class="nav-link active">
                    <img width="25" height="25" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyCAYAAAAeP4ixAAAACXBIWXMAAAsTAAALEwEAmpwYAAACxUlEQVR4nO2Yu49NQRzHZ7FIECFeHSJLIYhC9rrWo1LQildCFB6F6GhWxKNQYCMi/gBEsSHRUCGLpZFNUCg8glVZiY2VEGL5yMjv2FnnfWfOnXvjfLsz8zu/7/nM+c3jHKVKlSpVqtT/JKAF6CG7elUjClhJPt1XjSjgrDzgGdXkZdUvIO2qWQVUBeKdhlLNKoooK+Ah/lRxCeJL/UFZpQxmT6byw5/+lpWTN0dYVevXPDr/qrSHCxpU+N4u6eqqBaTDMcjqpLJKAalExWcFqYdGrVYJIC3A20zl5QmkPQtIrvLyABEqEwc5H+RJUnU00UMj6wCEPEk6HE30im8QF4o8W7lIrIBb1E+RE9ZFYiWJ5gGbgdPAXeAzDXi2In5zJe6GscBiYBdwAXgEfLeESN/UUqTnaS6QmCTjBG4ncA7oA37m3QSBLZYDYg0yJqJtCrAOOARcNXbh2LKSOK8gQ3KkPgVsAubGxM0CNgLHgJvAB+COHDcmA198g0RpALgBHAU2ADNTcug3V4hUBoBW4ESOnG+AbuAgsBaYqgHl+ocXEGCi/p8kscPANWA/sB04DDx2/DzDtXqkgVyWuFfAkoh+Xff7HCzN1h4qAWKFxAwC81OAtZGNrD1Uwo2XJKbTaFsjr3pIltEZxqg9sQCx9lAJIM8kZqFcT5eRM9VtxB+xALH2UAkgXyVmglyvj7h/0IjfYQFi69GbBKI3Mq3Zct0G/PonQZ8Rf0DazscmDXsMFO2hZDfW2ma0HTeMPurTqNF3Xdp3N5KHMlaJp8B4o71NSmCa0bZc9oBvweTM6LGnaA+lEwMvxUjvJ60xcQuA1xJ3MrPBiMfzIj3+CFhmfGTppW8rMEceYJGsIp+k/14wafMIWCpLbWEeJswLknUFmFSTwQhMoR6BkR6dvcBt4L0cF/S3x0X9p8QqeR09SpUqpZpfvwEgyUkisbZ/cwAAAABJRU5ErkJggg=="></i>
                    <p>Rute
                      <i class="right fas fa-angle-left"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    <li class="nav-item ml-4">
                      <a href="#map" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Nama Rute</p>
                      </a>
                    </li>
                    <li class="nav-item ml-4">
                      <a href="{{ route('smartbin-visit-rute') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Smartbin Visit</p>
                      </a>
                    </li>
                    <li class="nav-item ml-4">
                      <a href="#Jadwal" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Jadwal </p>
                      </a>
                    </li>
                  </ul>
                </li>
                <li class="nav-item">
                  <a href="{{ route('get-centimeter-data') }}" class="nav-link">
                    <img width="25" height="25" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyCAYAAAAeP4ixAAAACXBIWXMAAAsTAAALEwEAmpwYAAABy0lEQVR4nM3ZvyuFURwG8JdikWKg5A+gpCSWy01JYWdgkJKJgYFBJoZLMjDekpKSiUFKSvJbDAwyMRBuYr9F99HpHnWHy33vvef7fN9nPJ33POfznuGt93ieowAoBjAP4BWZ8wJgzjzjBS1IbizbRLygBcm3bBLyMbf192S8oAU2UvNpCTQEwCmCk5N8IMcITo5cnMyjIuAhb0AK5FwRcuYSsq0I2XIJifooDKV8H/yOt/hYN+oSMpupLWVuXuNpMuMSMgo9yIhLSK8ipMclpE0REnYJqVWE1LiElCtCylxCCgDEFSBx0+0MYgufFSBPThG28FoBciUB2VWA7EhAVhUgK/SfC0KQiARkXAEyJgHpV4D0SUA6FCDtEpB6BUidBKRSAVIhASkE8EWEfJtO5xBbGiNC3kQQtvSWCLmRhOwTIXuSkHUiZE0SskiELEhCJomQCUnIIBEyIAnpJkI6JSGNREiDJKSaCKmShBQBSBAgCdMlBrHFnwTIhyjCFt8TIHcMyCEBcsCAbBIgGwzI8h/l5vYpnOV4upsskyUGZBrymWJAhgmQIQakiwDpZEBKAbwLImIASsQhFtMM4PK/nxE5xKx1AaApl039ADHK3/YJmOgMAAAAAElFTkSuQmCC" />
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

    <div class="content-wrapper" style="min-height: 638.2px;">
      <!-- main content -->
      <section class="content">
        <!-- CSS map peta -->
        <style>
          #map {
            height: 100vh;
            width: 100%;

          }

          #map-input {
            padding: 10px;
            /* Tambahkan padding sesuai kebutuhan Anda */
          }
          .form-control-sidebar {
            max-width: 200px;
          }
          .highlighted {
            background-color: rgba(255, 255, 255, 0.725);
            /* Nilai alpha antara 0 (transparan) hingga 1 (tidak transparan) */
            padding: 1px;
            /* Tambahkan padding sesuai kebutuhan Anda */
            margin: 1px 0;
            /* Tambahkan margin sesuai kebutuhan Anda */
            display: block;
            /* Agar elemen menempati satu baris penuh */
          }

          .leaflet-routing-container {
            color: black !important;
            background-color: white !important;
          }

          .legend {
            background-color: #343a40;
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            position: absolute;
            right: 20px;
            left: auto;
            bottom: 20px;
            z-index: 1000;
            display: flex;
            flex-direction: row;
          }

          .legend-item {
            display: flex;
            align-items: center;
            margin-right: 15px;
            margin-bottom: 5px;
          }

          .legend-icon {
            width: 20px;
            height: 20px;
            margin-right: 8px;
          }
        </style>

        <div id="map-input">
          <form id="route-form">
            <label for="startCoord">Titik Awal:</label>
            <input type="text" id="startCoord" name="startCoord" placeholder="Lat, Long">
            <label for="endCoord">Titik Tujuan:</label>
            <input type="text" id="endCoord" name="endCoord" placeholder="Lat, Long">
            <button type="button" onclick="calculateRoute()">Cari Rute</button>
          </form>
        </div>
        <!-- Map Peta -->
        <div id="map">

          <!-- Legenda -->
          <div class="legend">
            <div class="legend-item">
              <i class="fas fa-circle nav-icon mr-2 text-danger"></i>
              Kapasitas 100 L
            </div>
            <div class="legend-item">
              <i class="fas fa-circle nav-icon mr-2 text-danger"></i>
              Penuh
            </div>
            <div class="legend-item">
              <i class="fas fa-circle nav-icon mr-2 text-warning"></i>
              Setengah
            </div>
            <div class="legend-item">
              <i class="fas fa-circle nav-icon mr-2 text-success"></i>
              Kosong
            </div>
          </div>

          <!-- Load Leaflet JavaScript library -->
          <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
          <script src="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.js"></script>
          <script>

            var map = L.map('map').setView([-6.244528, 106.832361], 16);
            var osm = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
              attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            });
            osm.addTo(map);

        // Tambahkan layer Google Streets
            var googleStreets = L.tileLayer('http://{s}.google.com/vt?lyrs=m&x={x}&y={y}&z={z}', {
                maxZoom: 20,
                subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
            });
            googleStreets.addTo(map);

            // Tambahkan layer Google Satellite
            var googleSat = L.tileLayer('http://{s}.google.com/vt?lyrs=s&x={x}&y={y}&z={z}', {
                maxZoom: 20,
                subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
            });

            // Tambahkan kontrol layer dan overlay
            var baseLayers = {
                "OpenStreetMap": osm,
                "Satellite": googleSat,
                "Google Map": googleStreets,
            };

            var overlays = {
                "ultrasonic_data": L.layerGroup().addTo(map)
            };

            L.control.layers(baseLayers, overlays).addTo(map);

            // Inisialisasi markers
            var ultrasonicData = {!! json_encode($ultrasonics) !!};

            ultrasonicData.forEach(function (data) {
                // Convert string numbers to actual numbers
                data.lat = parseFloat(data.lat);
                data.lng = parseFloat(data.lng);
                data.kosong = parseInt(data.kosong);
                data.setengah = parseInt(data.setengah);
                data.penuh = parseInt(data.penuh);
                data.kapasitas_sampah = parseInt(data.kapasitas_sampah);
                data.kapasitas_mobil = parseInt(data.kapasitas_mobil);

                var marker = L.circleMarker([data.lat, data.lng], {
                color: '#146C94',
                fillColor: '#19A7CE',
                opacity: 0.3,
                fillOpacity: 0.8,
                radius: 5,
                weight: 3,
                }).addTo(overlays["ultrasonic_data"]).bindPopup(
                "<br>Alamat: " + data.alamat +
                "<br>Lat: " + data.lat +
                "<br>Lng: " + data.lng +
                "<br>Kosong: " + data.kosong +
                "<br>Setengah: " + data.setengah +
                "<br>Penuh: " + data.penuh +
                "<br>Kapasitas Sampah: " + data.kapasitas_sampah +
                "<br>Kapasitas Mobil: " + data.kapasitas_mobil
                );

                // Add click event on the marker to show popup
            marker.on('click', L.bind(function (data, e) {
                var popup = L.popup()
                .setLatLng(e.latlng)
                .setContent(
                    "<br>Alamat: " + data.alamat +
                    "<br>Lat: " + data.lat +
                    "<br>Lng: " + data.lng +
                    "<br>Kosong: " + data.kosong +
                    "<br>Setengah: " + data.setengah +
                    "<br>Penuh: " + data.penuh +
                    "<br>Kapasitas Sampah: " + data.kapasitas_sampah +
                    "<br>Kapasitas Mobil: " + data.kapasitas_mobil
                )
                .openOn(map);
            }, null, data));
            });


            // Inisialisasi waypoints untuk routing
            var waypoints = {!! collect($ultrasonics)->filter(function($ultrasonic) {
                return is_array($ultrasonic) && array_key_exists('lat', $ultrasonic) && array_key_exists('lng', $ultrasonic);
            })->map(function($ultrasonic) {
                return ['lat' => $ultrasonic['lat'], 'lng' => $ultrasonic['lng']];
            })->values() !!};

            console.log(waypoints);

            var routingControl = L.Routing.control({
                waypoints: waypoints,
                routeWhileDragging: true
            }).addTo(map);

            // Fungsi untuk menghitung rute
            function calculateRoute() {
                var startCoord = document.getElementById('startCoord').value.split(',').map(parseFloat);
                var endCoord = document.getElementById('endCoord').value.split(',').map(parseFloat);
                routingControl.setWaypoints([L.latLng(startCoord), L.latLng(endCoord)]);
            }

            // Initialize DataTables
            $(document).ready(function () {
                $('ultrasonic_data').DataTable();
            });
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
        </div>


                    <!-- Menu Jadwal -->
            <div id="Jadwal">
                <div class="col-md-20 mt-3">
                    <div class="card">
                        <div class="card-header border-transparent">
                            <h3 class="card-title">Jadwal SmartBin</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table m-0">
                                    <thead>
                                        <tr>
                                            <th>Alamat</th>
                                            <th>Tanggal</th>
                                            <th>Indikator Sampah</th>
                                            <th>Kapasitas</th>
                                            <th>Titik Kordinat</th>

                                        </tr>
                                    </thead>
                                    <tbody id="JadwalBody">
                                        <!-- Data will be displayed here -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer clearfix">
                            <a href="javascript:void(0)" class="btn btn-sm btn-info float-left" id="inputDataBtn">Input Data</a>
                            <a href="javascript:void(0)" class="btn btn-sm btn-info float-right" id="hapusDataBtn" onclick="deleteData()">Hapus Data</a>

                        </div>
                        <!-- /.card-footer -->
                    </div>
                </div>
            </div>
      </section>

      <!-- Tambahkan script Bootstrap dan jQuery -->
      <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
      <!-- Tambahkan script Bootstrap (pastikan untuk menyertakan file Bootstrap sebelumnya) -->
      <script src="path/to/bootstrap.min.js"></script>

      <!-- Tambahkan script JavaScript -->

      <!-- Popup Modal -->
      <div class="modal fade" id="inputDataModal" tabindex="-1" role="dialog" aria-labelledby="inputDataModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="inputDataModalLabel">Input Data</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <!-- Form untuk mengisi data -->
              <form action="{{ route('simpan-data') }}" method="post">
                  @csrf
                <div class="form-group">
                  <label for="inputAlamat">Alamat</label>
                  <input type="text" class="form-control" id="inputAlamat" placeholder="Masukkan alamat" name="alamat" required>
                </div>
                <div class="form-group">
                  <label for="inputTanggal">Tanggal</label>
                  <input type="text" class="form-control" id="inputTanggal" placeholder="Masukkan tanggal" name="tanggal" required>
                </div>
                <div class="form-group">
                  <label for="inputIndikator">Indikator Sampah</label>
                  <input type="text" class="form-control" id="inputIndikator" placeholder="Masukkan indikator sampah" name="indikator" required>
                </div>
                <div class="form-group">
                  <label for="inputKapasitas">Kapasitas</label>
                  <input type="text" class="form-control" id="inputKapasitas" placeholder="Masukkan kapasitas" name="kapasitas" required>
                </div>
                <div class="form-group">
                  <label for="inputKoordinat">Titik Koordinat</label>
                  <input type="text" class="form-control" id="inputKoordinat" placeholder="Masukkan titik koordinat" name="koordinat" required>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" onclick="closeModal()">Tutup</button>
                  <button type="button" class="btn btn-primary">Simpan</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>

      <script>
        // Fungsi untuk membuka modal
        function openModal() {
          $('#inputDataModal').modal('show');
        }

        // Fungsi untuk menutup modal
        function closeModal() {
          $('#inputDataModal').modal('hide');
        }

            // Inisialisasi DataTables
        $(document).ready(function() {
            $('#jadwalTable').DataTable();
        });

        // Fungsi untuk menampilkan data ke dalam tabel
        function tampilkanData(response) {
            // Hapus data lama dari tabel
            $('#jadwalTable tbody').empty();

            // Iterasi melalui data dan tambahkan ke dalam tabel
            $.each(response, function(index, data) {
                $('#jadwalTable tbody').append(
                    '<tr>' +
                        '<td>' + data.alamat + '</td>' +
                        '<td>' + data.tanggal + '</td>' +
                        '<td>' + data.indikator + '</td>' +
                        '<td>' + data.kapasitas + '</td>' +
                        '<td>' + data.koordinat + '</td>' +
                    '</tr>'
                );
            });
        }

                // Fungsi untuk mengirim data formulir ke server
        function simpanData() {
            // Mendapatkan nilai dari input formulir
            var alamat = $('#inputAlamat').val();
            var tanggal = $('#inputTanggal').val();
            var indikator = $('#inputIndikator').val();
            var kapasitas = $('#inputKapasitas').val();
            var koordinat = $('#inputKoordinat').val();

            // Menggunakan AJAX untuk mengirim data ke server
            $.ajax({
            type: 'POST',
            url: '{{ route("simpan-data") }}',
            data: {
                _token: '{{ csrf_token() }}',
                alamat: alamat,
                tanggal: tanggal,
                indikator: indikator,
                kapasitas: kapasitas,
                koordinat: koordinat
            },
            success: function(response) {
                // Panggil fungsi untuk menampilkan data setelah berhasil disimpan
                tampilkanData(response);

                // Clear input formulir setelah berhasil disimpan
                $('#inputAlamat, #inputTanggal, #inputIndikator, #inputKapasitas, #inputKoordinat').val('');
            },
            error: function(error) {
                console.error('Gagal menyimpan data:', error);
            }
            });
        }

        // Menambahkan event listener pada tombol "Input Data"
        $('#inputDataBtn').on('click', function() {
          openModal();
        });

        // Menambahkan event listener pada tombol "Simpan"
        $('#inputDataModal').on('click', '.btn-primary', function() {
          simpanData();
        });

        $(document).ready(function() {
            // Function to fetch and display data
            function fetchDataAndDisplay() {
              $.ajax({
                url: '/tampil-data', // Replace with the actual URL to fetch data
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                  if (response.data) {
                    // Clear existing rows
                    $('#Jadwal tbody').empty();

                    // Append new rows with fetched data
                    $.each(response.data, function(index, data) {
                      var newRow = '<tr>' +
                        '<td>' + data.alamat + '</td>' +
                        '<td>' + data.tanggal + '</td>' +
                        '<td>' + data.indikator + '</td>' +
                        '<td>' + data.kapasitas + '</td>' +
                        '<td>' + data.koordinat + '</td>' +
                        '</tr>';
                      $('#Jadwal tbody').append(newRow);
                    });
                  }
                },
                error: function(error) {
                  console.log('Error fetching data:', error);
                }
              });
            }

            // Call the function to fetch and display data initially
            fetchDataAndDisplay();

            // Add click event to the "Tampilkan Data" button
            $('#tampilkanDataBtn').on('click', function() {
              // Call the function to fetch and display data when the button is clicked
              fetchDataAndDisplay();
            });
          });

    // Call the function to fetch and display data initially
    fetchDataAndDisplay();

    // Add click event to the "Tampilkan Data" button
    $('#tampilkanDataBtn').on('click', function() {
        // Call the function to fetch and display data when the button is clicked
        fetchDataAndDisplay();
    });

    //hapus
    function deleteData() {
        // Implementasi logika penghapusan satu baris data dari yang terakhir
        // Anda dapat menggunakan AJAX atau metode lain sesuai kebutuhan
        var lastRowId = $('#JadwalBody tr:last').data('id');

        if (lastRowId) {
            // Lakukan logika penghapusan menggunakan lastRowId
            $.ajax({
                url: '/delete-data', // Ganti dengan URL sebenarnya untuk penghapusan
                method: 'DELETE',
                dataType: 'json',
                data: {
                    ids: [lastRowId]
                },
                success: function(response) {
                    // Tangani respons sukses
                    console.log('Baris terakhir dihapus:', response);
                    // Panggil fungsi untuk mengambil dan menampilkan data setelah penghapusan
                    fetchDataAndDisplay();
                },
                error: function(error) {
                    console.log('Error menghapus baris terakhir:', error);
                }
            });
        } else {
            alert('Silahkan Hubungi Admin');
        }
    }

    //ambil coordinate
    $.ajax({
        url: '/get-coordinates',
        method: 'GET',
        dataType: 'json',
        success: function(data) {
          var routingControl = L.Routing.control({
            waypoints: data.waypoints,
            routeWhileDragging: true
          }).addTo(map);
        },
        error: function(error) {
          console.error('Error fetching coordinates:', error);
        }
      });
    </script>
      <!-- Control Sidebar -->
      <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
      </aside>
      <!-- ./wrapper -->
    </div>
  </div>
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

</body>

</html>
@endsection
