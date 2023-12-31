@extends('layouts.app')

@section('title', 'Tambah Data Pemanfaatan Massa Air di Kawasan Konservasi ' . $triwulan)

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
                            <h4>Tambah Data Pemanfaatan Massa Air di Kawasan Konservasi</h4>
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
                            <form action="{{ route('pemanfaatanair.store', ['triwulan' => $triwulan]) }}" method="POST">
                                @csrf
                                <input type="hidden" name="triwulan" value="{{ $triwulan }}">

                                <div class="form-group">
                                    <label for="nama_sumber_air">Nama Sumber Air</label>
                                    <input type="text" class="form-control" name="nama_sumber_air"
                                        value="{{ old('nama_sumber_air') }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="jenis_izin">Jenis Izin</label>
                                    <select class="form-control" name="jenis_izin" required>
                                        <option value="IPA" {{ old('jenis_izin')==='IPA' ? 'selected' : '' }}>IPA
                                        </option>
                                        <option value="IUPA" {{ old('jenis_izin')==='IUPA' ? 'selected' : '' }}>IUPA
                                        </option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="nomor_izin">Nomor Izin</label>
                                    <input type="text" class="form-control" name="nomor_izin"
                                        value="{{ old('nomor_izin') }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="tanggal_izin">Tanggal Izin</label>
                                    <input type="date" class="form-control" name="tanggal_izin"
                                        value="{{ old('tanggal_izin') }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="nama">Nama</label>
                                    <input type="text" class="form-control" name="nama" value="{{ old('nama') }}"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="kabupaten_id">Kabupaten</label>
                                    <select name="kabupaten_id" id="kabupaten" class="form-control" required>
                                        <option value="">Pilih Kabupaten</option>
                                        @foreach($kabupaten as $kab)
                                        <option value="{{ $kab->id }}">{{ $kab->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="kecamatan_id">Kecamatan</label>
                                    <select name="kecamatan_id" id="kecamatan" class="form-control" required disabled>
                                        <option value="">Pilih Kecamatan</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="desa_id">Desa</label>
                                    <select name="desa_id" id="desa" class="form-control" required disabled>
                                        <option value="">Pilih Desa</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="jumlah_dilayani_kk">Jumlah yang Dilayani (KK)</label>
                                    <input type="number" class="form-control" name="jumlah_dilayani_kk"
                                        value="{{ old('jumlah_dilayani_kk') }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="debit">Debit yang Dimanfaatkan (M3/Detik)</label>
                                    <input type="number" step="0.01" class="form-control" name="debit"
                                        value="{{ old('debit') }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="jumlah_tenaga_kerja">Jumlah Tenaga Kerja (Orang)</label>
                                    <input type="number" class="form-control" name="jumlah_tenaga_kerja"
                                        value="{{ old('jumlah_tenaga_kerja') }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="nilai_investasi">Nilai Investasi (Rp)</label>
                                    <input type="number" step="0.01" class="form-control" name="nilai_investasi"
                                        value="{{ old('nilai_investasi') }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="keterangan">Keterangan</label>
                                    <textarea class="form-control" name="keterangan" rows="3"
                                        placeholder="Masukkan keterangan (Optional)"></textarea>
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

        kabupatenSelect.addEventListener('change', function () {
            // Hapus pilihan sebelumnya pada dropdown kecamatan dan desa
            kecamatanSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';
            desaSelect.innerHTML = '<option value="">Pilih Desa</option>';

            // Mendapatkan nilai id kabupaten yang dipilih
            var selectedKabupatenId = kabupatenSelect.value;

            // Jika id kabupaten tidak kosong, aktifkan dropdown kecamatan
            if (selectedKabupatenId) {
                kecamatanSelect.disabled = false;

                // TODO: Ajax request untuk mendapatkan data kecamatan sesuai dengan id kabupaten
                // Contoh:
                fetch('/get-kecamatan/' + selectedKabupatenId)
                    .then(response => response.json())
                    .then(data => {
                        // Update dropdown kecamatan dengan data yang diterima
                        data.forEach(kecamatan => {
                            var option = document.createElement('option');
                            option.value = kecamatan.id;
                            option.textContent = kecamatan.nama;
                            kecamatanSelect.appendChild(option);
                        });
                    })
                    .catch(error => console.error('Error:', error));
            } else {
                kecamatanSelect.disabled = true;
                desaSelect.disabled = true;
            }
        });

        kecamatanSelect.addEventListener('change', function () {
            // Hapus pilihan sebelumnya pada dropdown desa
            desaSelect.innerHTML = '<option value="">Pilih Desa</option>';

            // Mendapatkan nilai id kecamatan yang dipilih
            var selectedKecamatanId = kecamatanSelect.value;

            // Jika id kecamatan tidak kosong, aktifkan dropdown desa
            if (selectedKecamatanId) {
                desaSelect.disabled = false;

                // TODO: Ajax request untuk mendapatkan data desa sesuai dengan id kecamatan
                // Contoh:
                fetch('/get-desa/' + selectedKecamatanId)
                    .then(response => response.json())
                    .then(data => {
                        // Update dropdown desa dengan data yang diterima
                        data.forEach(desa => {
                            var option = document.createElement('option');
                            option.value = desa.id;
                            option.textContent = desa.nama;
                            desaSelect.appendChild(option);
                        });
                    })
                    .catch(error => console.error('Error:', error));
            } else {
                desaSelect.disabled = true;
            }
        });
    });
</script>
@endpush