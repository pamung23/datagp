@extends('layouts.app')

@section('title', 'Edit data Potensi Wisata Alam di Kawasan Konservasi ' . $triwulan)

@push('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('plugins/bootstrap-select/bootstrap-select.min.css') }}">
<link href="{{ asset('plugins/flatpickr/flatpickr.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('plugins/flatpickr/custom-flatpickr.css') }}" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="{{ asset('plugins/select2/select2.min.css') }}">
@endpush

@section('content')
<div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
    <div class="statbox widget box box-shadow">
        <div class="widget-header">
            <div class="row">
                <div class="col-xl-12 col-md-12 col-sm-12 col-12" style="margin-left: 12px;">
                    <br>
                    <h3>Triwulan {{ $triwulan }}</h3>
                    <h4>Edit Potensi Wisata Alam di Kawasan Konservasi</h4>
                </div>
            </div>
        </div>
        <div class="widget-content widget-content-area">
            <div class="row">
                <div class="col-lg-7 col-12 mx-auto">
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <form action="{{ route('potensiodtwa.update', ['triwulan' => $triwulan, 'id' => $data->id]) }}"
                        method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="triwulan" value="{{ $triwulan }}">
                        <div class="form-group">
                            <label for="nama_zona_blok_pemanfaatan">Nama Zona/Blok Pemanfaatan</label>
                            <input type="text" class="form-control" name="nama_zona_blok_pemanfaatan"
                                value="{{ $data->nama_zona_blok_pemanfaatan }}" required>
                        </div>
                        <div class="form-group">
                            <label for="luas_zona_blok_pemanfaatan">Luas Zona/Blok Pemanfaatan</label>
                            <input type="number" class="form-control" name="luas_zona_blok_pemanfaatan"
                                value="{{ $data->luas_zona_blok_pemanfaatan }}" step="0.01" required>
                        </div>
                        <div class="form-group">
                            <label for="jenis_odtwa">Jenis ODTWA</label>
                            <select class="form-control" name="jenis_odtwa" required>
                                <option value="">Pilih Jenis ODTWA</option>
                                <option value="Pemandangan" {{ $data->jenis_odtwa === 'Pemandangan' ? 'selected' : ''
                                    }}>Pemandangan</option>
                                <option value="Air Terjun" {{ $data->jenis_odtwa === 'Air Terjun' ? 'selected' : ''
                                    }}>Air Terjun</option>
                                <option value="Kawah" {{ $data->jenis_odtwa === 'Kawah' ? 'selected' : '' }}>Kawah
                                </option>
                                <option value="Udara Sejuk" {{ $data->jenis_odtwa === 'Udara Sejuk' ? 'selected' : ''
                                    }}>Udara Sejuk</option>
                                <option value="Pendakian" {{ $data->jenis_odtwa === 'Pendakian' ? 'selected' : ''
                                    }}>Pendakian</option>
                                <option value="Gua" {{ $data->jenis_odtwa === 'Gua' ? 'selected' : '' }}>Gua</option>
                                <option value="Landscape/Seascape" {{ $data->jenis_odtwa === 'Landscape/Seascape' ?
                                    'selected' : '' }}>Landscape/Seascape</option>
                                <option value="Lain-lain" {{ $data->jenis_odtwa === 'Lain-lain' ? 'selected' : ''
                                    }}>Lain-lain</option>
                            </select>
                        </div>
                        <div id="map" style="height: 400px;"></div>
                        <div class="form-group">
                            <label for="latitude">Latitude</label>
                            <input type="text" class="form-control" name="latitude" value="{{ $data->latitude }}"
                                step="0.01" required>
                        </div>
                        <div class="form-group">
                            <label for="longitude">Longitude</label>
                            <input type="text" class="form-control" name="longitude" value="{{ $data->longitude }}"
                                step="0.01" required>
                        </div>
                        <div class="form-group">
                            <label for="jenis_atraksi_wisata">Jenis Atraksi Wisata</label>
                            <select class="form-control" name="jenis_atraksi_wisata" required>
                                <option value="">Pilih Jenis Atraksi Wisata</option>
                                <option value="Tracking/hiking/climbing" {{ $data->jenis_atraksi_wisata ===
                                    'Tracking/hiking/climbing' ? 'selected' : '' }}>Tracking/hiking/climbing</option>
                                <option value="Berkemah" {{ $data->jenis_atraksi_wisata === 'Berkemah' ? 'selected' : ''
                                    }}>Berkemah</option>
                                <option value="Caving" {{ $data->jenis_atraksi_wisata === 'Caving' ? 'selected' : ''
                                    }}>Caving</option>
                                <option value="Pengamatan hidupan liar" {{ $data->jenis_atraksi_wisata === 'Pengamatan
                                    hidupan liar' ? 'selected' : '' }}>Pengamatan hidupan liar</option>
                                <option value="Memancing" {{ $data->jenis_atraksi_wisata === 'Memancing' ? 'selected' :
                                    '' }}>Memancing</option>
                                <option value="Canopy trail" {{ $data->jenis_atraksi_wisata === 'Canopy trail' ?
                                    'selected' : '' }}>Canopy trail</option>
                                <option value="Outbond training" {{ $data->jenis_atraksi_wisata === 'Outbond training' ?
                                    'selected' : '' }}>Outbond training</option>
                                <option value="Lain-lain" {{ $data->jenis_atraksi_wisata === 'Lain-lain' ? 'selected' :
                                    '' }}>Lain-lain</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="pengusahaan_oleh_pihak_iii">Pengusahaan oleh Pihak III</label>
                            <select class="form-control" name="pengusahaan_oleh_pihak_iii" required>
                                <option value="">Pilih Pengusahaan oleh Pihak III</option>
                                <option value="Ada" @if($data->pengusahaan_oleh_pihak_iii == "Ada") selected
                                    @endif>Ada
                                </option>
                                <option value="Tidak ada" @if($data->pengusahaan_oleh_pihak_iii == "Tidak ada")
                                    selected
                                    @endif>Tidak ada</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <textarea class="form-control" name="keterangan">{{ $data->keterangan }}</textarea>
                        </div>
                        <!-- Other form fields -->
                        <div class="form-group" id="prasarana-container">
                            <label>Prasarana</label>
                            <table class="table table-bordered table-responsive-lg" id="prasarana-table">
                                <thead>
                                    <tr>
                                        <th class="col-md-4">Jenis Sarana/Prasarana</th>
                                        <th class="col-md-4">Jumlah Unit</th>
                                        <th class="col-md-4">Kondisi</th>
                                        <th class="col-md-4">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data->jenis_prasarana as $index => $jenisPrasarana)
                                    <tr class="prasarana-item">
                                        <td>
                                            <input type="text" name="jenis_prasarana[]" class="form-control"
                                                placeholder="Jenis Sarana/Prasarana" value="{{ $jenisPrasarana }}"
                                                required>
                                        </td>
                                        <td>
                                            <input type="number" name="jumlah_unit[]" class="form-control"
                                                placeholder="Jumlah Unit" value="{{ $data->jumlah_unit[$index] }}"
                                                required>
                                        </td>
                                        <td>
                                            <input type="text" name="kondisi[]" class="form-control"
                                                placeholder="Kondisi" value="{{ $data->kondisi[$index] }}" required>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-danger btn-remove">Hapus</button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <!-- Tombol Tambah -->
                            <button type="button" class="btn btn-success btn-add">Tambah Prasarana</button>
                        </div>
                        <!-- Other form fields -->

                        <button type="submit" class="btn btn-primary mt-4">Simpan</button>
                    </form>
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
    $(document).ready(function () {
        // Tombol Tambah Prasarana
        $(".btn-add").click(function () {
            var newRow = $(".prasarana-item:first").clone();
            newRow.find("input").val(""); // Kosongkan nilai input
            newRow.find(".btn-remove").show(); // Tampilkan tombol hapus pada baris baru
            $("#prasarana-table tbody").append(newRow);
        });

        // Tombol Hapus Prasarana
        $(document).on("click", ".btn-remove", function () {
            $(this).closest("tr").remove();
        });
    });
</script>
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