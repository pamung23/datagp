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
        <div class="col-lg-12 layout-spacing">
            <div class="statbox widget box box-shadow">
                <div class="widget-header">
                    <div class="row">
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                            <h4>Edit Kemitraan Konservasi</h4>
                        </div>
                    </div>
                </div>
                <div class="widget-content widget-content-area">
                    @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                    @endif

                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <div class="row">
                        <div class="col-lg-6 col-12 mx-auto">
                            <form action="{{ route('kemitraankonservasi.update', $kemitraankonservasi->id) }}"
                                method="POST">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <input type="hidden" name="nomor_register_original"
                                        value="{{ $kemitraankonservasi->nomor_register }}">
                                </div>
                                <div class="form-group">
                                    <label for="desa_id">Kelurahan/Desa:</label>
                                    <select name="desa_id" class="form-control select2" required>
                                        <option value="">Pilih Kelurahan/Desa</option>
                                        @foreach ($desas as $desa)
                                        <option value="{{ $desa->id }}" {{ $kemitraankonservasi->desa_id == $desa->id ?
                                            'selected' : '' }}>{{ $desa->desa }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="nama_kelompok">Nama Kelompok</label>
                                    <input type="text" name="nama_kelompok" class="form-control"
                                        value="{{ $kemitraankonservasi->nama_kelompok }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="jumlah_anggota">Anggota (Orang)</label>
                                    <input type="number" name="jumlah_anggota" class="form-control"
                                        value="{{ $kemitraankonservasi->jumlah_anggota }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="luas_pks">Luas PKS (Ha)</label>
                                    <input type="number" name="luas_pks" class="form-control"
                                        value="{{ $kemitraankonservasi->luas_pks }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="zona_blok">Zona/Blok</label>
                                    <input type="text" name="zona_blok" class="form-control"
                                        value="{{ $kemitraankonservasi->zona_blok }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="bentuk_kemitraan">Bentuk Kemitraan</label>
                                    <input type="text" name="bentuk_kemitraan" class="form-control"
                                        value="{{ $kemitraankonservasi->bentuk_kemitraan }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="nilai_ekonomi_per_tahun">Perkiraan Nilai Ekonomi per Tahun (Rp)</label>
                                    <input type="number" name="nilai_ekonomi_per_tahun" class="form-control"
                                        value="{{ $kemitraankonservasi->nilai_ekonomi_per_tahun }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="keterangan">Keterangan (Opsional):</label>
                                    <input type="text" name="keterangan" class="form-control"
                                        value="{{ $kemitraankonservasi->keterangan }}"
                                        placeholder="Keterangan (opsional)">
                                </div>
                                <!-- Tambahkan elemen formulir lainnya sesuai kebutuhan -->
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
    $(document).ready(function () {
        // Inisialisasi Select2
        $('.select2').select2();
    });
</script>
@endpush