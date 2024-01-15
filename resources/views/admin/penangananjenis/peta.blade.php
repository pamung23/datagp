@extends('layouts.app')

@section('title', 'Potensi Wisata Alam di Kawasan Konservasi')

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
                    <h4>Penanganan Jenis Asing Invasif (IAS) di Kawasan Konservasi</h4>
                </div>
                <div class="col-xl-6 col-md-6 col-sm-6 col-6 text-right" style="margin-top: 20px">
                    <a href="{{ route('penangananjenis.index') }}" class="btn btn-outline-primary btn-sm ">Kembali</a>
                </div>
            </div>

        </div>
    </div>
    <div class="widget-content widget-content-area br-6">
        <div id="map" data-latitude="{{ $data->latitude }}" data-longitude="{{ $data->longitude }}"></div>
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
    const latitude = document.getElementById('map').getAttribute('data-latitude');
    const longitude = document.getElementById('map').getAttribute('data-longitude');
    const semester = "{{ $semester }}";
    const ilmiah = "{{ $data->ilmiah }}"; // Ganti dengan cara akses data yang benar
    const map = L.map('map').setView([{{ $latitude }}, {{ $longitude }}], 11);
    
        const tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);
    
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

  // Create a layer from datajson with the specified style
  var datajsonJSON = L.geoJson(datajson, {
        style: doStyledatajson
    });
    const marker = L.marker([latitude, longitude])
        .addTo(map)
        .bindPopup(`<b>Nama Ilmiah: ${ilmiah}</b><br><b>semester: ${semester}</b><br>Latitude: ${latitude}<br>Longitude: ${longitude}`)
        .openPopup(); // Buka popup secara default
</script>
@endpush