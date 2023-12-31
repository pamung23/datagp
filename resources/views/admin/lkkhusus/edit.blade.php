@extends('layouts.app')

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
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12" style="margin-left: 12px;">
                            <br>
                            <h3>Triwulan {{ $triwulan }}</h3>
                            <h4>Edit Data Lembaga Konservasi Khusus</h4>
                        </div>
                    </div>
                </div>
                <div class="widget-content widget-content-area">
                    <div class="row">
                        <div class="col-lg-6 col-12 mx-auto">
                            @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                            <form action="{{ route('lkkhusus.update', ['triwulan' => $triwulan, 'id' => $data->id]) }}"
                                method="POST" id="pembinaan-form">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="triwulan" value="{{ $triwulan }}">
                                <div class="form-group">
                                    <label for="bentuk_lk">Bentuk Lembaga Konservasi Khusus</label>
                                    <select class="form-control @error('bentuk_lk') is-invalid @enderror" id="bentuk_lk"
                                        name="bentuk_lk" required>
                                        <option value="Pusat Penyelamatan Satwa" {{ $data->bentuk_lk === 'Pusat Penyelamatan Satwa' ? 'selected' : '' }}>Pusat Penyelamatan Satwa</option>
                                        <option value="Pusat Latihan Satwa Khusus" {{ $data->bentuk_lk === 'Pusat Latihan Satwa Khusus' ? 'selected' : '' }}>Pusat Latihan Satwa Khusus</option>
                                        <option value="Pusat Rehabilitasi Satwa" {{ $data->bentuk_lk === 'Pusat Rehabilitasi Satwa' ? 'selected' : '' }}>Pusat Rehabilitasi Satwa</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="nama_lk">Nama LK</label>
                                    <input type="text" class="form-control @error('nama_lk') is-invalid @enderror"
                                        id="nama_lk" name="nama_lk" value="{{ $data->nama_lk }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="alamat_lk">Alamat LK</label>
                                    <input type="text" class="form-control @error('alamat_lk') is-invalid @enderror"
                                        id="alamat_lk" name="alamat_lk" value="{{ $data->alamat_lk }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="provinsi">Provinsi</label>
                                    <input type="text" class="form-control @error('provinsi') is-invalid @enderror"
                                        id="provinsi" name="provinsi" value="{{ $data->provinsi }}" required>
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
                                    <label for="luas_areal_hektar">Luas Areal (Ha)</label>
                                    <input type="number"
                                        class="form-control @error('luas_areal_hektar') is-invalid @enderror"
                                        id="luas_areal_hektar" name="luas_areal_hektar"
                                        value="{{ $data->luas_areal_hektar }}" required>
                                </div>
                                <div class="thick-hr"></div>
                                <h6>Izin Lembaga Konservasi</h6>
                                <div class="form-group">
                                    <label for="nomor">Nomor</label>
                                    <input type="text" class="form-control @error('nomor') is-invalid @enderror"
                                        id="nomor" name="nomor" value="{{ $data->nomor }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="tanggal">Tanggal</label>
                                    <input type="date" class="form-control @error('tanggal') is-invalid @enderror"
                                        id="tanggal" name="tanggal" value="{{ $data->tanggal }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="masa_berlaku_tahun">Masa Berlaku (Tahun)</label>
                                    <input type="number"
                                        class="form-control @error('masa_berlaku_tahun') is-invalid @enderror"
                                        id="masa_berlaku_tahun" name="masa_berlaku_tahun"
                                        value="{{ $data->masa_berlaku_tahun }}" required>
                                </div>
                                <div class="thick-hr"></div>
                                <h6>Koleksi pada Lembaga Konservasi</h6>
                                <div class="form-group">
                                    <label for="nama_ilmiah">Nama Ilmiah</label>
                                    <input type="text" class="form-control @error('nama_ilmiah') is-invalid @enderror"
                                        id="nama_ilmiah" name="nama_ilmiah" value="{{ $data->nama_ilmiah }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="jantan">Jantan</label>
                                    <input type="number" class="form-control @error('jantan') is-invalid @enderror"
                                        id="jantan" name="jantan" value="{{ $data->jantan }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="betina">Betina</label>
                                    <input type="number" class="form-control @error('betina') is-invalid @enderror"
                                        id="betina" name="betina" value="{{ $data->betina }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="belum_diketahui">Belum Diketahui</label>
                                    <input type="number"
                                        class="form-control @error('belum_diketahui') is-invalid @enderror"
                                        id="belum_diketahui" name="belum_diketahui" value="{{ $data->belum_diketahui }}"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="jumlah">Jumlah</label>
                                    <input type="number" class="form-control" id="jumlah" name="jumlah"
                                        value="{{ $data->jumlah }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="keterangan">Keterangan</label>
                                    <textarea class="form-control" name="keterangan">{{ $data->keterangan }}</textarea>
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
<script>
    function calculateJumlah() {
        var jantan = parseFloat(document.getElementById("jantan").value) || 0;
        var betina = parseFloat(document.getElementById("betina").value) || 0;
        var belumDiketahui = parseFloat(document.getElementById("belum_diketahui").value) || 0;
        var jumlah = jantan + betina + belumDiketahui;
        document.getElementById("jumlah").value = jumlah;
    }

    // Tambahkan event listener untuk menghitung "jumlah" saat kolom "jantan," "betina," atau "belum_diketahui" berubah
    document.getElementById("jantan").addEventListener("input", calculateJumlah);
    document.getElementById("betina").addEventListener("input", calculateJumlah);
    document.getElementById("belum_diketahui").addEventListener("input", calculateJumlah);
</script>

<script>
    document.getElementById("luas_areal_hektar").addEventListener("input", function () {
        var value = this.value;
        
        // Hilangkan semua karakter selain angka, koma, dan titik
        value = value.replace(/[^0-9,.]/g, '');

        // Gantilah tanda koma (,) dengan titik (.) jika diperlukan
        value = value.replace(/,/g, '.');

        // Pastikan hanya ada satu tanda titik (.) dalam angka
        var decimalCount = (value.match(/\./g) || []).length;
        if (decimalCount > 1) {
            value = value.substr(0, value.lastIndexOf('.'));
        }

        this.value = value;
    });
    document.getElementById("latitude").addEventListener("input", function () {
        var value = this.value;
        // Gantilah tanda koma (,) dengan titik (.) jika diperlukan
        value = value.replace(/,/g, '.');
        this.value = value;
    });

    // Fungsi untuk mengubah format input longitude (X)
    document.getElementById("longitude").addEventListener("input", function () {
        var value = this.value;
        // Gantilah tanda koma (,) dengan titik (.) jika diperlukan
        value = value.replace(/,/g, '.');
        this.value = value;
    });
    
</script>
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