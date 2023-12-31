@extends('layouts.app')

@section('title', 'Edit Data Kerjasama Penyelenggaraan KSA dan KPA ' . $semester)

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
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12" style="margin-left: 12px;">
                            <br>
                            <h3>Semester {{ $semester }}</h3>
                            <h4>Kerjasama Penyelenggaraan KSA dan KPA</h4>
                        </div>
                    </div>
                </div>
                <div class="widget-content widget-content-area">
                    <div class="row">
                        <div class="col-lg-8 col-12 mx-auto">
                            @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                            <form action="{{ route('kerjasama.update', ['semester' => $semester, 'id' => $data->id]) }}"
                                method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="semester" value="{{ $semester }}">

                                <!-- Tipe Kerjasama -->
                                <div class="form-group">
                                    <label for="tipe_kerjasama">Tipe Kerjasama</label>
                                    <select class="form-control" id="tipe_kerjasama" name="tipe_kerjasama" required>
                                        <option value="Penguatan Fungsi" {{ old('tipe_kerjasama', $data->tipe_kerjasama)
                                            == 'Penguatan Fungsi' ? 'selected' : '' }}>Penguatan Fungsi</option>
                                        <option value="Pembangunan Strategis" {{ old('tipe_kerjasama', $data->
                                            tipe_kerjasama) == 'Pembangunan Strategis' ? 'selected' : '' }}>Pembangunan
                                            Strategis</option>
                                    </select>
                                    @error('tipe_kerjasama')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Mitra Kerjasama -->
                                <div class="form-group">
                                    <label for="mitra_kerjasama">Mitra Kerjasama</label>
                                    <input type="text" class="form-control" id="mitra_kerjasama" name="mitra_kerjasama"
                                        value="{{ old('mitra_kerjasama', $data->mitra_kerjasama) }}" required>
                                    @error('mitra_kerjasama')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Judul Kerjasama -->
                                <div class="form-group">
                                    <label for="judul_kerjasama">Judul Kerjasama</label>
                                    <input type="text" class="form-control" id="judul_kerjasama" name="judul_kerjasama"
                                        value="{{ old('judul_kerjasama', $data->judul_kerjasama) }}" required>
                                    @error('judul_kerjasama')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Ruang Lingkup Kerjasama -->
                                <div class="form-group">
                                    <label for="ruang_lingkup_kerjasama">Ruang Lingkup Kerjasama</label>
                                    <input type="text" class="form-control" id="ruang_lingkup_kerjasama"
                                        name="ruang_lingkup_kerjasama"
                                        value="{{ old('ruang_lingkup_kerjasama', $data->ruang_lingkup_kerjasama) }}"
                                        required>
                                    @error('ruang_lingkup_kerjasama')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Nomor MoU/PKS -->
                                <div class="form-group">
                                    <label for="nomor_mou">Nomor MoU/PKS</label>
                                    <input type="text" class="form-control" id="nomor_mou" name="nomor_mou"
                                        value="{{ old('nomor_mou', $data->nomor_mou) }}" required>
                                    @error('nomor_mou')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Tanggal MoU/PKS -->
                                <div class="form-group">
                                    <label for="tanggal_mou">Tanggal MoU/PKS</label>
                                    <input id="basicFlatpickr3" class="form-control flatpickr flatpickr-input active"
                                        type="text" placeholder="Pilih Tanggal.." id="tanggal_mou" name="tanggal_mou"
                                        value="{{ old('tanggal_mou', $data->tanggal_mou) }}" required>
                                    @error('tanggal_mou')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Tanggal Awal Berlaku -->
                                <div class="form-group">
                                    <label for="tanggal_awal_berlaku">Tanggal Awal Berlaku</label>
                                    <input id="basicFlatpickr1" class="form-control flatpickr flatpickr-input"
                                        type="text" placeholder="Pilih Tanggal.." id="tanggal_awal_berlaku"
                                        name="tanggal_awal_berlaku"
                                        value="{{ old('tanggal_awal_berlaku', $data->tanggal_awal_berlaku) }}" required>
                                    @error('tanggal_awal_berlaku')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Tanggal Akhir Berlaku -->
                                <div class="form-group">
                                    <label for="tanggal_akhir_berlaku">Tanggal Akhir Berlaku</label>
                                    <input id="basicFlatpickr2" class="form-control flatpickr flatpickr-input active"
                                        type="text" placeholder="Pilih Tanggal.." id="tanggal_akhir_berlaku"
                                        name="tanggal_akhir_berlaku"
                                        value="{{ old('tanggal_akhir_berlaku', $data->tanggal_akhir_berlaku) }}"
                                        required>
                                    @error('tanggal_akhir_berlaku')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Keterangan -->
                                <div class="form-group">
                                    <label for="keterangan">Keterangan</label>
                                    <textarea class="form-control" name="keterangan" rows="3"
                                        placeholder="Masukkan keterangan (Optional)">{{ old('keterangan', $data->keterangan) }}</textarea>
                                    @error('keterangan')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Tombol Simpan -->
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
<script src="{{ asset('assets/js/scrollspyNav.js') }}"></script>
<script>
    var f1 = flatpickr(document.getElementById('basicFlatpickr3'));
    var f1 = flatpickr(document.getElementById('basicFlatpickr1'));
    var f1 = flatpickr(document.getElementById('basicFlatpickr2'));
</script>
@endpush