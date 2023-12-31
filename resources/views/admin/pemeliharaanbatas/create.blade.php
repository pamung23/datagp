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
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                            <h3>Semester {{ $semester }}</h3>
                            <h4>Tambah Data Pemeliharaan Batas Kawasan Konservasi</h4>
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
                            <form action="{{ route('pemeliharaanbatas.store', ['semester' => $semester]) }}"
                                method="POST">
                                @csrf
                                <input type="hidden" name="semester" value="{{ $semester }}">
                                <h6>Pemeliharaan Batas Kawasan Konservasi</h6>
                                <div class="form-group">
                                    <label for="p_batas">Panjang Batas (KM)</label>
                                    <input type="number" class="form-control" name="p_batas"
                                        placeholder="Masukkan Panjang Batas " required>
                                </div>
                                <div class="thick-hr"></div>
                                <h6>Pelaksanaan Pemeliharaan Batas</h6>
                                <div class="form-group">
                                    <label for="tahun">Tahun</label>
                                    <input type="date" class="form-control" name="tahun" placeholder="Masukkan Tahun"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="panjang">Panjang (KM)</label>
                                    <input type="number" class="form-control" name="panjang"
                                        placeholder="Masukkan Panjang" required>
                                </div>
                                <div class="form-group">
                                    <label for="jmlh_batas">Jumlah Pal Batas</label>
                                    <input type="number" class="form-control" name="jmlh_batas"
                                        placeholder="Masukkan Jumlah Pal Batas" required>
                                </div>
                                <div class="thick-hr"></div>
                                <h6>Berita Acara/Laporan Pemeliharaan Batas</h6>
                                <div class="form-group">
                                    <label for="nomor">Nomor</label>
                                    <input type="number" class="form-control" name="nomor" placeholder="Masukkan Nomor"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="tanggal">Tanggal</label>
                                    <input type="date" class="form-control" name="tanggal"
                                        placeholder="Masukkan Tanggal" required>
                                </div>
                                <hr>
                                <div class="form-group">
                                    <label for="keterangan">Keterangan</label>
                                    <textarea class="form-control" name="keterangan" rows="3"
                                        placeholder="Masukkan keterangan (Optional)"></textarea>
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