@extends('layouts.app')

@section('title', 'Promosi dan Publikasi Jasa Lingkungan Kawasan Konservasi')

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
<style>
    #map {
        height: 500px;
    }
</style>
@endpush

@section('content')
<div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
    <div class="statbox widget box box-shadow">
        <div class="widget-header">
            <div class="row py-2 m-auto">
                <div class="col-xl-6 col-md-6 col-sm-6 col-6">
                    <h4>Promosi dan Publikasi Jasa Lingkungan Kawasan Konservasi</h4>
                </div>

            </div>
        </div>
        <div class="widget-content widget-content-area br-6">
            <div id="map"></div>
        </div>
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
    const map = L.map('map').setView([-6.747446210258649, 106.9672966499052], 11);
    
        const tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);
       

        // // Adding GeoJSON layer to the map
        // L.geoJSON(datajson).addTo(map);
        // L.geoJSON(json_LandUse).addTo(map);
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

// Buat layer dari datajson dengan gaya yang ditetapkan
var datajsonJSON = L.geoJson(datajson, {
    style: doStyledatajson
});

// // Masukkan layer ke dalam array layerOrder
// layerOrder[layerOrder.length] = datajsonJSON;

// // Tambahkan setiap layer pada layerOrder ke dalam peta
// for (index = 0; index < layerOrder.length; index++) {
//     feature_group.removeLayer(layerOrder[index]);
//     feature_group.addLayer(layerOrder[index]);
// }

// // Tambahkan layer datajsonJSON ke dalam feature_group (munculkan pada peta)
// feature_group.addLayer(datajsonJSON);
// raster_group.addTo(map);
// feature_group.addTo(map);

// // Tambahkan kontrol skala pada peta
// L.control.scale({
//     options: {
//         position: 'bottomleft',
//         maxWidth: 100,
//         metric: true,
//         imperial: false,
//         updateWhenIdle: false
//     }
// }).addTo(map);
</script>
@endpush