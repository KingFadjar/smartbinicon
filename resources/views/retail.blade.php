@extends('layouts.app')

@section('content')

    <div id="map"></div>

    <!-- Load Leaflet JavaScript library -->
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        // Inisialisasi peta dan set tampilan
        //var map = L.map('map').setView([-6.235279747898276, 106.8208198373647], 13);
        var map = L.map('map', {
            center: [-6.235279747898276, 106.8208198373647],
            zoom: 13,
            renderer: L.canvas()
        });

        // Tambahkan layer OSM
        var osm = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        });
        osm.addTo(map);

        // Tambahkan marker tunggal dengan popup
        var singleMarker = L.marker([-6.235279747898276, 106.8208198373647]);
        singleMarker.addTo(map);
        var popup = singleMarker.bindPopup('pln icon plus');
        popup.addTo(map);

        // Tambahkan layer OpenStreetMap_BZH
        var OpenStreetMap_BZH = L.tileLayer('https://tile.openstreetmap.bzh/br/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, Tiles courtesy of <a href="http://www.openstreetmap.bzh/" target="_blank">Breton OpenStreetMap Team</a>',
            bounds: [[46.2, -5.5], [50, 0.7]]
        });
        OpenStreetMap_BZH.addTo(map);

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
        googleSat.addTo(map);

        // Tambahkan kontrol layer dan overlay
        var baseLayers = {
            "OpenStreetMap": osm,
            "Satelite": googleSat,
            "Google Map": googleStreets,
        };

        var overlays = {
            "Marker": singleMarker,
            "Pop Amarta": L.layerGroup(),
            "Dil Retail": L.layerGroup(),
        };

        L.control.layers(baseLayers, overlays).addTo(map);

        //Loop untuk setiap data yang diterima dari query
        //data pop
        @foreach($popData as $data)
            // Tambahkan marker untuk setiap data
            var marker = L.circleMarker([{{ $data->lat }}, {{ $data->lng }}], {
                color: '#146C94',
                fillColor: '#19A7CE',
                opacity: 0.3,
                fillOpacity: 0.8,
                radius: 5,
                weight: 3,
            }).addTo(overlays["Pop Amarta"]).bindPopup("POP ID: {{ $data->pop_id }}<br>POP Name: {{ $data->pop_name }}<br>POP Address: {{ $data->pop_address }}");

            // Tambahkan event click pada marker untuk menampilkan popup
            marker.on('click', function () {
                marker.openPopup();
            });
        @endforeach

        //dil pelanggan
        @foreach($retailData as $data)
            // Tambahkan marker untuk setiap data
            var marker = L.circleMarker([{{ $data->latitude }}, {{ $data->longitude }}], {
                color: '#FFD700',
                fillColor: '#FFD700',
                opacity: 0.3,
                fillOpacity: 0.8,
                radius: 5,
                weight: 3,
            }).addTo(overlays["Dil Retail"]).bindPopup("idpelanggan: {{ $data->idpelanggan }}<br>idpln: {{ $data->idpln }}<br>namasbu: {{ $data->namasbu }}<br>Status: {{ $data->status }}<br>Detail Status: {{ $data->detailstatus }}<br>Product: {{ $data->product }}");

            // Tambahkan event click pada marker untuk menampilkan popup
            marker.on('click', function () {
                marker.openPopup();
            });
        @endforeach

        //fungsi untuk search
        function f_searching(){
            var kata = document.getElementById('p_search').value;
            console.log("cari = "+kata);
            $.ajax({
                url:"{{ url('') }}/search",
                async:true,
                type:"GET",
                data: {
                    keyword: kata
                },
                dataType:"json",
                success: function(response) {
                    // Manipulasi tampilan atau data hasil pencarian
                    //console.log('berhasiiill');
                    console.log("hasil = "+JSON.stringify(response.pop_amarta_0223));
                    console.log("hasil = " +JSON.stringify(response.dilJatengKorporat));
                     // Hapus marker Pop Amarta sebelumnya
            overlays["Pop Amarta"].clearLayers();

            // Tambahkan marker baru untuk setiap data hasil pencarian
            response.pop_amarta_0223.forEach(function (data) {
                var marker = L.circleMarker([data.lat, data.lng], {
                    color: '#146C94',
                    fillColor: '#19A7CE',
                    opacity: 0.3,
                    fillOpacity: 0.8,
                    radius: 5,
                    weight: 3,
                }).addTo(overlays["Pop Amarta"]).bindPopup("POP ID: " + data.pop_id + "<br>POP Name: " + data.pop_name + "<br>POP Address: " + data.pop_address);

                // Tambahkan event click pada marker untuk menampilkan popup
                marker.on('click', function () {
                    marker.openPopup();
                });
            });
            response.pelangganIconnet.forEach(function (data) {
                var marker = L.circleMarker([data.latitude, data.longitude], {
                    color: '#FFD700',
                    fillColor: '#FFD700',
                    opacity: 0.3,
                    fillOpacity: 0.8,
                    radius: 5,
                    weight: 3
                }).addTo(overlays["Dil Retail"]).bindPopup("idpelanggan: " + data.idpelanggan + "<br>idpln: " + data.idpln + "<br>namasbu: " + data.namasbu + "<br>Status: " + data.status + "<br>Detail Status: " + data.detailstatus + "<br>Product: " + data.product);

                // Tambahkan event click pada marker untuk menampilkan popup
                marker.on('click', function () {
                    marker.openPopup();
                });
            });
                },
                error: function(xhr, status, error) {
                    // Tangani kesalahan yang terjadi saat permintaan Ajax
                    console.log('gagaaaaall');
                }
            })
        }


    </script>

@endsection
