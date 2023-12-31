@extends('layouts.app')

@section('title', 'Edit Data Pemanfaatan Massa Air di Kawasan Konservasi ' . $triwulan)

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
                            <h3>Triwulan {{$triwulan }}</h3>
                            <h4>Edit Data Pemanfaatan Massa Air di Kawasan Konservasi</h4>
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
                                action="{{ route('pemanfaatanair.update', ['triwulan' => $triwulan, 'id' => $data->id]) }}"
                                method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="triwulan" value="{{ $triwulan }}">

                                <div class="form-group">
                                    <label for="nama_sumber_air">Nama Sumber Air</label>
                                    <input type="text" class="form-control" name="nama_sumber_air"
                                        value="{{ $data->nama_sumber_air }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="jenis_izin">Jenis Izin</label>
                                    <select class="form-control" name="jenis_izin" required>
                                        <option value="IPA" {{ $data->jenis_izin === 'IPA' ? 'selected' : '' }}>IPA
                                        </option>
                                        <option value="IUPA" {{ $data->jenis_izin === 'IUPA' ? 'selected' : '' }}>IUPA
                                        </option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="nomor_izin">Nomor Izin</label>
                                    <input type="text" class="form-control" name="nomor_izin"
                                        value="{{ $data->nomor_izin }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="tanggal_izin">Tanggal Izin</label>
                                    <input type="date" class="form-control" name="tanggal_izin"
                                        value="{{ $data->tanggal_izin }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="nama">Nama</label>
                                    <input type="text" class="form-control" name="nama" value="{{ $data->nama }}"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="kabupaten_id">Kabupaten</label>
                                    <select name="kabupaten_id" id="kabupaten" class="form-control" required>
                                        <option value="">Pilih Kabupaten</option>
                                        @foreach($kabupaten as $kab)
                                        <option value="{{ $kab->id }}" {{ $data->kabupaten_id == $kab->id ? 'selected' :
                                            '' }}>
                                            {{ $kab->nama }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="kecamatan_id">Kecamatan</label>
                                    <select name="kecamatan_id" id="kecamatan" class="form-control" required>
                                        <option value="">Pilih Kecamatan</option>
                                        @foreach($kecamatan as $kec)
                                        <option value="{{ $kec->id }}" {{ $data->kecamatan_id == $kec->id ? 'selected' :
                                            '' }}>
                                            {{ $kec->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="desa_id">Desa</label>
                                    <select name="desa_id" id="desa" class="form-control" required>
                                        <option value="">Pilih Desa</option>
                                        @foreach($desa as $ds)
                                        <option value="{{ $ds->id }}" {{ $data->desa_id == $ds->id ? 'selected' : '' }}>
                                            {{ $ds->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="jumlah_dilayani_kk">Jumlah yang Dilayani (KK)</label>
                                    <input type="number" class="form-control" name="jumlah_dilayani_kk"
                                        value="{{ $data->jumlah_dilayani_kk }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="debit">Debit yang Dimanfaatkan (M3/Detik)</label>
                                    <input type="number" step="0.01" class="form-control" name="debit"
                                        value="{{ $data->debit }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="jumlah_tenaga_kerja">Jumlah Tenaga Kerja (Orang)</label>
                                    <input type="number" class="form-control" name="jumlah_tenaga_kerja"
                                        value="{{ $data->jumlah_tenaga_kerja }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="nilai_investasi">Nilai Investasi (Rp)</label>
                                    <input type="number" step="0.01" class="form-control" name="nilai_investasi"
                                        value="{{ $data->nilai_investasi }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="keterangan">Keterangan</label>
                                    <textarea class="form-control" name="keterangan" rows="3"
                                        placeholder="Masukkan keterangan (Optional)">{{ $data->keterangan }}</textarea>
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
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var kabupatenSelect = document.getElementById('kabupaten');
        var kecamatanSelect = document.getElementById('kecamatan');
        var desaSelect = document.getElementById('desa');

        // Populate Kabupaten dropdown
        kabupatenSelect.addEventListener('change', function () {
            // Reset Kecamatan and Desa dropdowns
            kecamatanSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';
            desaSelect.innerHTML = '<option value="">Pilih Desa</option>';

            // Get the selected Kabupaten ID
            var selectedKabupatenId = kabupatenSelect.value;

            // If a Kabupaten is selected, populate Kecamatan dropdown
            if (selectedKabupatenId) {
                // Simulate AJAX call or use actual AJAX call to get Kecamatan data
                var kecamatanOptions = []; // Replace with actual data

                // Populate Kecamatan dropdown
                kecamatanOptions.forEach(function (kecamatan) {
                    var option = document.createElement('option');
                    option.value = kecamatan.id;
                    option.textContent = kecamatan.nama;
                    kecamatanSelect.appendChild(option);
                });

                // Preselect the value based on the data
                kecamatanSelect.value = {{ $data->kecamatan_id }};
            }
        });

        // Populate Kecamatan dropdown
        kecamatanSelect.addEventListener('change', function () {
            // Reset Desa dropdown
            desaSelect.innerHTML = '<option value="">Pilih Desa</option>';

            // Get the selected Kecamatan ID
            var selectedKecamatanId = kecamatanSelect.value;

            // If a Kecamatan is selected, populate Desa dropdown
            if (selectedKecamatanId) {
                // Simulate AJAX call or use actual AJAX call to get Desa data
                var desaOptions = []; // Replace with actual data

                // Populate Desa dropdown
                desaOptions.forEach(function (desa) {
                    var option = document.createElement('option');
                    option.value = desa.id;
                    option.textContent = desa.nama;
                    desaSelect.appendChild(option);
                });

                // Preselect the value based on the data
                desaSelect.value = {{ $data->desa_id }};
            }
        });

        // Trigger change event on Kabupaten to populate Kecamatan and Desa dropdowns on page load
        kabupatenSelect.dispatchEvent(new Event('change'));
    });
</script>
@endpush