@extends('layouts.app')

@push('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('plugins/bootstrap-select/bootstrap-select.min.css') }}">
<link href="{{ asset('plugins/flatpickr/flatpickr.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('plugins/flatpickr/custom-flatpickr.css') }}" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="{{ asset('plugins/select2/select2.min.css') }}">
<style>
    .thick-hr {
        border: none;
        border-top: 3px solid #000;
        /* Mengatur ketebalan dan warna garis */
        margin: 10px 0;
        /* Jarak atas dan bawah garis */
    }
</style>
@endpush

@section('content')
<div class="container">
    <div class="row layout-top-spacing">
        <div id="basic" class="col-lg-12 layout-spacing">
            <div class="statbox widget box box-shadow">
                <div class="widget-header">
                    <div class="row">
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12 " style="margin-left: 12px;">
                            <br>
                            <h3>Semester {{ $semester }}</h3>
                            <h4>Penanganan Jenis Asing Invasif (IAS) di Kawasan Konservasi</h4>
                        </div>
                    </div>
                </div>
                <div class="widget-content widget-content-area">
                    <div class="row">
                        <div class="col-lg-6 col-12 mx-auto">
                            <!-- Pemberitahuan error -->
                            @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                            <form
                                action="{{ route('penangananjenis.update', ['semester' => $semester, 'id' => $data->id]) }}"
                                method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="semester" value="{{ $semester }}">
                                <div class="form-group">
                                    <label for="ilmiah">Nama Ilmiah</label>
                                    <input type="text" class="form-control" name="ilmiah"
                                        placeholder="Masukkan Nama Ilmiah" required value="{{ $data->ilmiah }}">
                                </div>
                                <div class="form-group">
                                    <label for="luas">Luas (Ha)</label>
                                    <input type="number" class="form-control" name="luas"
                                        placeholder="Masukkan Luas (Ha)" required value="{{ $data->luas }}">
                                </div>
                                <div id="map" style="height: 400px;"></div>
                                <div class="form-group">
                                    <label for="latitude">Latitude</label>
                                    <input type="text" class="form-control" name="latitude"
                                        value="{{ $data->latitude }}" step="0.01" required>
                                </div>
                                <div class="form-group">
                                    <label for="longitude">Longitude</label>
                                    <input type="text" class="form-control" name="longitude"
                                        value="{{ $data->longitude }}" step="0.01" required>
                                </div>
                                <div class="form-group">
                                    <label for="penanganan">Penanganan yang sudah dilakukan</label>
                                    <input type="text" class="form-control" name="penanganan"
                                        placeholder="Masukkan Penanganan yang sudah dilakukan" required
                                        value="{{ $data->penanganan }}">
                                </div>
                                <div class="form-group">
                                    <label for="rencana">Rencana Penanganan</label>
                                    <input type="text" class="form-control" name="rencana"
                                        placeholder="Masukkan Rencana Penanganan" required value="{{ $data->rencana }}">
                                </div>
                                <div class="form-group">
                                    <label for="kemitraan">kemitraan</label>
                                    <input type="text" class="form-control" name="kemitraan"
                                        placeholder="Masukkan Kemitraan yang dilakukan" required
                                        value="{{ $data->kemitraan }}">
                                </div>
                                <hr>
                                <div class="form-group">
                                    <label for="keterangan">Keterangan</label>
                                    <textarea class="form-control" name="keterangan" rows="3"
                                        placeholder="Masukkan keterangan (Optional)">{{ $data->keterangan }}</textarea>
                                </div>
                                <button type="submit" class="btn btn-primary mt-4" id="submit-button">Simpan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('plugins/bootstrap-select/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('plugins/select2/select2.min.js') }}"></script>
<script src="{{ asset('plugins/select2/custom-select2.js') }}"></script>
<script src="{{ asset('plugins/flatpickr/flatpickr.js') }}"></script>
<script src="{{ asset('plugins/flatpickr/custom-flatpickr.js') }}"></script>
<script src="{{ asset('peta/datajson.js') }}"></script>
<script src="{{ asset('peta/json_LandUse.js') }}"></script>
<script>
    // Inisialisasi peta
const map = L.map('map').setView([-6.747446210258649, 106.9672966499052], 11);

// Tambahkan tile layer (misalnya OpenStreetMap)
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
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
// Inisialisasi marker pada posisi awal (tanpa ditambahkan ke peta)
const marker = L.marker([{{$data->latitude}}, {{$data->longitude}}]);

// Tambahkan marker ke peta
marker.addTo(map);

// Event listener untuk menangkap koordinat ketika peta diklik
map.on('click', function(e) {
    const lat = e.latlng.lat.toFixed(6);
    const lng = e.latlng.lng.toFixed(6);

    // Isi input field dengan koordinat yang dipilih oleh pengguna
    document.querySelector('input[name="latitude"]').value = lat;
    document.querySelector('input[name="longitude"]').value = lng;

    // Ubah posisi marker sesuai dengan titik yang dipilih
    marker.setLatLng(e.latlng);
});

// Event listener untuk memantau perubahan nilai pada input latitude dan longitude
document.querySelector('input[name="latitude"]').addEventListener('input', function(e) {
    const newLat = parseFloat(e.target.value);
    const newLng = parseFloat(document.querySelector('input[name="longitude"]').value);

    // Perbarui posisi marker sesuai dengan nilai yang diinputkan
    marker.setLatLng([newLat, newLng]);
    map.setView([newLat, newLng]);
});

document.querySelector('input[name="longitude"]').addEventListener('input', function(e) {
    const newLng = parseFloat(e.target.value);
    const newLat = parseFloat(document.querySelector('input[name="latitude"]').value);

    // Perbarui posisi marker sesuai dengan nilai yang diinputkan
    marker.setLatLng([newLat, newLng]);
    map.setView([newLat, newLng]);
});
</script>

@endpush