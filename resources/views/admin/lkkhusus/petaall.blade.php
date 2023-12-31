@extends('layouts.app')

@section('title', 'Lembaga Konservasi Khusus')

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
<style>
    #map {
        height: 500px;
    }

    .legend {
        margin-top: 20px;
        margin-right: 20px;
        margin-bottom: 20px;
        display: flex;
        flex-direction: column;
    }

    .legend h5 {
        margin-bottom: 10px;
    }

    .legend ul {
        display: flex;
        flex-direction: row;
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .legend li {
        margin-right: 20px;
        /* Jarak antara setiap item */
        display: flex;
        align-items: center;
    }

    .legend span {
        display: inline-block;
        width: 20px;
        height: 20px;
        margin-right: 5px;
        border-radius: 50%;
    }

    /* Warna marker untuk keterangan triwulan */
    .green-marker {
        background-color: rgb(37, 198, 37);
        /* Warna hijau untuk triwulan 1 */
    }

    .red-marker {
        background-color: #d60000;
        /* Warna merah untuk triwulan 2 */
    }

    .blue-marker {
        background-color: rgb(78, 134, 219);
        /* Warna biru untuk triwulan 3 */
    }

    .yellow-marker {
        background-color: rgb(203, 186, 0);
        /* Warna kuning untuk triwulan 4 */
    }
</style>
@endpush

@section('content')
<div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
    <div class="statbox widget box box-shadow">
        <div class="widget-header">
            <div class="row py-2 m-auto">
                <div class="col-xl-6 col-md-6 col-sm-6 col-6">
                    <h4>Lembaga Konservasi Khusus</h4>
                </div>
                <div class="col-xl-6 col-md-6 col-sm-6 col-6 text-right" style="margin-top: 20px">
                    <a href="{{ route('potensiodtwa.index') }}" class="btn btn-outline-primary btn-sm ">Kembali</a>
                </div>
            </div>

        </div>
        <div class="widget-content widget-content-area br-6">
            <div class="legend">
                <h6>Keterangan Warna Marker Triwulan:</h6>
                <ul>
                    <li><span class="green-marker"></span> Triwulan 1</li>
                    <li><span class="red-marker"></span> Triwulan 2</li>
                    <li><span class="blue-marker"></span> Triwulan 3</li>
                    <li><span class="yellow-marker"></span> Triwulan 4</li>
                </ul>
            </div>
            <div id="map"></div>

        </div>
    </div>
    @endsection

    @push('scripts')
    <!-- Make sure you put this AFTER Leaflet's CSS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script src="{{ asset('peta/datajson.js') }}"></script>
    <script src="{{ asset('peta/json_LandUse.js') }}"></script>
    <script>
        // Buat ikon dengan warna yang berbeda untuk setiap triwulan
    const greenIcon = new L.Icon({
        iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-green.png',
        shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
        iconSize: [25, 41],
        iconAnchor: [12, 41],
        popupAnchor: [1, -34],
        shadowSize: [41, 41]
        });
        
        const redIcon = new L.Icon({
        iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png',
        shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
        iconSize: [25, 41],
        iconAnchor: [12, 41],
        popupAnchor: [1, -34],
        shadowSize: [41, 41]
        });
        
        const blueIcon = new L.Icon({
        iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-blue.png',
        shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
        iconSize: [25, 41],
        iconAnchor: [12, 41],
        popupAnchor: [1, -34],
        shadowSize: [41, 41]
        });
        
        const yellowIcon = new L.Icon({
        iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-yellow.png',
        shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
        iconSize: [25, 41],
        iconAnchor: [12, 41],
        popupAnchor: [1, -34],
        shadowSize: [41, 41]
        });

    const map = L.map('map').setView([-6.747446210258649, 106.9672966499052], 11);
    const tiles = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);

    const basemaps = {
        'Satelit': L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
            attribution: 'Tiles © Esri'
        }),
        'OpenStreetMap': tiles
    };

    L.control.layers(basemaps).addTo(map);

    const encodedData = "{{ $encodedData }}";
    const decodedData = JSON.parse(atob(encodedData));
    const allDataByQuarter = decodedData;
    const quarterLayers = {};
    const yearGroups = {};

    Object.keys(allDataByQuarter).forEach(triwulan => {
        const dataForQuarter = allDataByQuarter[triwulan];
        let icon;

        switch (triwulan) {
            case '1':
                icon = greenIcon;
                break;
            case '2':
                icon = redIcon;
                break;
            case '3':
                icon = blueIcon;
                break;
            case '4':
                icon = yellowIcon;
                break;
            default:
                icon = greenIcon;
                break;
        }

        quarterLayers[`Triwulan ${triwulan}`] = L.layerGroup().addTo(map);

        dataForQuarter.forEach(dataPoint => {
            const year = new Date(dataPoint.created_at).getFullYear();
            const marker = L.marker([dataPoint.latitude, dataPoint.longitude], { icon: icon })
                .bindPopup(`<b>Triwulan: ${dataPoint.triwulan}</b><br><b>Tahun: ${year}</b><br><b>Nama Lembaga Konservasi: ${dataPoint.nama_lk}</b><br><b>Nama Ilmiah: ${dataPoint.nama_ilmiah}</b><br><b>Jantan: ${dataPoint.jantan}</b><br><b>Betina: ${dataPoint.betina}</b><br><b>Belum DiKetahui: ${dataPoint.belum_diketahui}</b><br><b>Jumlah: ${dataPoint.jumlah}</b><br>Latitude: ${dataPoint.latitude}<br>Longitude: ${dataPoint.longitude}`)
                .addTo(quarterLayers[`Triwulan ${triwulan}`]);

            if (!yearGroups[year]) {
                yearGroups[year] = L.layerGroup();
            }

            marker.addTo(yearGroups[year]);
        });
    });
    const triwulanControl = L.control.layers(null, quarterLayers, { collapsed: false });
const tahunControl = L.control.layers(null, yearGroups, { collapsed: false });

triwulanControl.addTo(map);
tahunControl.addTo(map);

map.on('overlayadd overlayremove', function (eventLayer) {
    if (eventLayer.name.startsWith('Triwulan')) {
        // Layer Triwulan ditambah atau dihapus
        const selectedYear = document.querySelector('input[name="tahun"]:checked');
        if (selectedYear) {
            yearGroups[selectedYear.value].eachLayer(function (layer) {
                layer.addTo(map);
            });
        }
    } else {
        // Layer Tahun ditambah atau dihapus
        if (map.hasLayer(eventLayer.layer)) {
            eventLayer.layer.eachLayer(function (layer) {
                layer.addTo(map);
            });
        } else {
            eventLayer.layer.eachLayer(function (layer) {
                map.removeLayer(layer);
            });
        }
    }
});

// Menandai (check) tahun berdasarkan data yang ada saat peta dimuat
map.eachLayer(function (layer) {
    if (map.hasLayer(layer)) {
        tahunControl._overlaysList.querySelector(`input[value="${layer._leaflet_id}"]`).checked = true;
    }
});

    </script>
    <script>
        function doStyleLandUse(feature) {
        let fillColor;
        switch (feature.properties.Classific) {
            case 'Agriculture':
                fillColor = '#93422282';
                break;
            case 'Forest':
                fillColor = '#c2d45b85';
                break;
            case 'Open Field':
                fillColor = '#b0502682';
                break;
            case 'Plantation':
                fillColor = '#2be35f82';
                break;
            case 'Rawa':
                fillColor = '#3bc32682';
                break;
            case 'Settlements':
                fillColor = '#53f52680';
                break;
            case 'Shrubs':
                fillColor = '#1911b880';
                break;
            case 'Swamp':
                fillColor = '#89498482';
                break;
            case 'Tubuh air':
                fillColor = '#6976e685';
                break;
            default:
                fillColor = '#000000'; // Warna default jika tidak ada kecocokan
        }

        return {
            weight: '1.04',
            fillColor: fillColor,
            color: '',
            dashArray: '',
            opacity: '1.0',
            fillOpacity: '1.0',
        };
        }
        // Tambahkan GeoJSON layer dengan gaya yang diatur
        L.geoJSON(json_LandUse, {
            style: doStyleLandUse
        }).addTo(map);

        function doStyledatajson(feature) {
        return {
            weight: 1.04,
            color: '#ff0101',
            fillColor: '#c95568',
            dashArray: '',
            opacity: 0.3,
            fillOpacity: 0.0
        };
        }
    </script>

    @endpush