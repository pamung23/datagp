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
                            <h4>Tambah Data Kawasan Konservasi yang Mendapat Penetapan Status Internasional sebagai
                                Cagar Biosfer</h4>
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
                            <form action="{{ route('kawasankonservasi.store') }}" method="POST"
                                id="kawasankonservasi-form">
                                @csrf
                                <input type="hidden" name="semester" value="{{ $semester }}">
                                <div class="form-group">
                                    <label for="nama_cagar_biosfer">Nama Cagar Biosfer</label>
                                    <input type="text" class="form-control" name="nama_cagar_biosfer"
                                        placeholder="Masukkan nama cagar biosfer" required>
                                </div>
                                <div class="form-group">
                                    <label for="tahun_penetapan">Tahun Penerbitan Izin</label>
                                    <select class="form-control selectpicker" name="tahun_penetapan" required>
                                        <option value="">Pilih Tahun</option>
                                        @foreach($years as $year)
                                        <option value="{{ $year }}">{{ $year }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="thick-hr"></div>
                                <h6>Kawasan Konservasi di dalam Cagar Biosfer</h6>
                                <div class="form-group">
                                    <label for="area_inti">Area Inti</label>
                                    <input type="text" class="form-control" name="area_inti"
                                        placeholder="Masukkan area inti" required>
                                </div>
                                <div class="form-group">
                                    <label for="zona_penyangga">Zona Penyangga</label>
                                    <input type="text" class="form-control" name="zona_penyangga"
                                        placeholder="Masukkan zona penyangga" required>
                                </div>
                                <div class="form-group">
                                    <label for="area_transisi">Area Transisi</label>
                                    <input type="text" class="form-control" name="area_transisi"
                                        placeholder="Masukkan area transisi" required>
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