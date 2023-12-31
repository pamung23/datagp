@extends('layouts.app')

@section('title', 'Tambah Data Potensi Pemanfaatan Air di Kawasan Konservasi' . $triwulan)

@push('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('plugins/bootstrap-select/bootstrap-select.min.css') }}">
<link href="{{ asset('plugins/flatpickr/flatpickr.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('plugins/flatpickr/custom-flatpickr.css') }}" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="{{ asset('plugins/select2/select2.min.css') }}">
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
                            <h3>Triwulan {{ $triwulan }}</h3>
                            <h4>Tambah Data Potensi Pemanfaatan Air di Kawasan Konservasi</h4>
                        </div>
                    </div>
                </div>
                <div class="widget-content widget-content-area">
                    <div class="row">
                        <div class="col-lg-7 col-12 mx-auto">
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
                            <form action="{{ route('potensiair.store', ['triwulan' => $triwulan]) }}" method="POST">
                                @csrf
                                <input type="hidden" name="triwulan" value="{{ $triwulan }}">
                                <div class="form-group">
                                    <label for="nama_sumber_air">Nama Sumber Air</label>
                                    <input type="text" class="form-control" name="nama_sumber_air" required>
                                </div>
                                <div class="form-group">
                                    <label for="debit">Debit (M3/Detik)</label>
                                    <input type="text" class="form-control" name="debit" pattern="[-.,\d]+"
                                        onkeypress="return event.charCode >= 48 && event.charCode <= 57 || event.charCode === 44 || event.charCode === 46"
                                        oninput="limitDecimalPlaces(this, 4)" required>
                                </div>
                                <div id="map" style="height: 400px;"></div>
                                <div class="form-group">
                                    <label for="latitude">Latitude</label>
                                    <input type="text" class="form-control" name="latitude" step="0.01" required>
                                </div>
                                <div class="form-group">
                                    <label for="longitude">Longitude</label>
                                    <input type="text" class="form-control" name="longitude" step="0.01" required>
                                </div>
                                <div class="form-group">
                                    <label for="massa_air">Massa Air</label>
                                    <input type="text" class="form-control" name="massa_air" pattern="[-.,\d]+"
                                        onkeypress="return event.charCode >= 48 && event.charCode <= 57 || event.charCode === 44 || event.charCode === 46"
                                        oninput="limitDecimalPlaces(this, 4)" required>
                                </div>
                                <div class="form-group">
                                    <label for="energi_air">Energi Air</label>
                                    <input type="text" class="form-control" name="energi_air" pattern="[-.,\d]+"
                                        onkeypress="return event.charCode >= 48 && event.charCode <= 57 || event.charCode === 44 || event.charCode === 46"
                                        oninput="limitDecimalPlaces(this, 4)">
                                </div>
                                <div class="form-group">
                                    <label for="nomor">Nomor </label>
                                    <input type="text" class="form-control" name="nomor" required>
                                </div>
                                <div class="form-group">
                                    <label for="tanggal">Tanggal</label>
                                    <input id="basicFlatpickr" type="date"
                                        class="form-control flatpickr flatpickr-input" name="tanggal" required>
                                </div>
                                <div class="form-group">
                                    <label for="pengusahaan_pihak_iii">Pengusahaan oleh Pihak III</label>
                                    <input type="text" class="form-control" name="pengusahaan_pihak_iii">
                                </div>
                                <div class="form-group">
                                    <label for="keterangan">Keterangan</label>
                                    <textarea class="form-control" name="keterangan"></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary mt-4">Simpan</button>
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
    // Menggunakan event listener untuk mendengarkan input pada field dengan nama 'luas_ha_parsial'
    document.addEventListener("DOMContentLoaded", function() {
        var luasHaInputs = document.querySelectorAll('input[name="debit"], input[name="massa_air"], input[name="energi_air"]');
        luasHaInputs.forEach(function(input) {
            input.addEventListener('input', function() {
                // Mengganti koma dengan titik pada input
                var parsed = this.value.replace(',', '.');
                this.value = parsed;
            });
        });
    });
</script>
<script>
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
        const marker = L.marker([-6.747446210258649, 106.9672966499052]);

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