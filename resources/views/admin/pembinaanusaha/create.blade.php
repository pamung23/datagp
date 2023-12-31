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
                            <h4>Tambah Data Pembinaan Usaha Ekonomi Produktif pada Daerah Penyangga Kawasan Konservasi
                            </h4>
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
                            <form action="{{ route('pembinaanusaha.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="triwulan" value="{{ $triwulan }}">
                                <div class="form-group">
                                    <label for="nama_kelompok">Nama Kelompok</label>
                                    <input type="text" class="form-control @error('nama_kelompok') is-invalid @enderror"
                                        id="nama_kelompok" name="nama_kelompok" required>
                                </div>
                                <div class="form-group">
                                    <label for="anggota">Anggota</label>
                                    <input type="number" class="form-control @error('anggota') is-invalid @enderror"
                                        id="anggota" name="anggota" required>

                                </div>
                                <div class="form-group">
                                    <label for="jenis_kegiatan">Jenis Kegiatan</label>
                                    <input type="text"
                                        class="form-control @error('jenis_kegiatan') is-invalid @enderror"
                                        id="jenis_kegiatan" name="jenis_kegiatan" required>
                                </div>
                                <div class="form-group">
                                    <label for="jumlah_dana">Jumlah Dana</label>
                                    <input type="number" class="form-control @error('jumlah_dana') is-invalid @enderror"
                                        id="jumlah_dana" value="0" name="jumlah_dana" required>
                                </div>
                                <div class="form-group">
                                    <label for="sumber_dana">Sumber Dana</label>
                                    <input type="text" class="form-control @error('sumber_dana') is-invalid @enderror"
                                        id="sumber_dana" name="sumber_dana" required>

                                </div>
                                <div class="form-group">
                                    <label for="hasil_manfaat">Hasil Manfaat</label>
                                    <input type="text" class="form-control @error('hasil_manfaat') is-invalid @enderror"
                                        id="hasil_manfaat" name="hasil_manfaat" required>
                                </div>
                                <div class="form-group">
                                    <label for="pendamping">Pendamping</label>
                                    <input type="text" class="form-control @error('pendamping') is-invalid @enderror"
                                        id="pendamping" name="pendamping" required>
                                </div>
                                <div class="form-group">
                                    <label for="keterangan">Keterangan</label>
                                    <textarea class="form-control" id="keterangan" name="keterangan"></textarea>
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
@endpush