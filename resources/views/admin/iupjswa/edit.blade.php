@extends('layouts.app')
@section('title', 'Edit Data Pengusahaan Pemanfaatan Jasa Lingkungan Wisata Alam ' . $triwulan)
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
                            <h4>Edit Data Pengusahaan Pemanfaatan Jasa Lingkungan Wisata Alam</h4>
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
                            <form action="{{ route('iupjswa.update', ['triwulan' => $triwulan, 'id' => $data->id]) }}"
                                method="POST">
                                @method('PUT')
                                @csrf
                                <input type="hidden" name="triwulan" value="{{ $triwulan }}">
                                <div class="form-group">
                                    <label for="nama_zona_blok_pemanfaatan">Nama Zona Blok Pemanfaatan</label>
                                    <input type="text" class="form-control" name="nama_zona_blok_pemanfaatan"
                                        value="{{ $data->nama_zona_blok_pemanfaatan }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="luas_zona_blok_pemanfaatan">Luas Zona Blok Pemanfaatan (ha)</label>
                                    <input type="number" class="form-control" name="luas_zona_blok_pemanfaatan"
                                        step="0.01" value="{{ $data->luas_zona_blok_pemanfaatan }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="iupswa_nama_perusahaan">Nama Perusahaan</label>
                                    <input type="text" class="form-control" name="iupswa_nama_perusahaan"
                                        value="{{ $data->iupswa_nama_perusahaan }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="iupswa_tahun_penerbitan">Tahun Penerbitan Izin Usaha</label>
                                    <select class="form-control selectpicker" name="iupswa_tahun_penerbitan" required>
                                        <option value="">Pilih Tahun</option>
                                        @foreach($years as $year)
                                        <option value="{{ $year }}" {{ $data->iupswa_tahun_penerbitan == $year ?
                                            'selected' : '' }}>{{ $year }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="iupswa_luas_area">Luas Area (ha)</label>
                                    <input type="number" class="form-control" name="iupswa_luas_area" step="0.01"
                                        value="{{ $data->iupswa_luas_area }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="iupjwa_nama_pemegang_izin">Nama Pemegang Izin</label>
                                    <input type="text" class="form-control" name="iupjwa_nama_pemegang_izin"
                                        value="{{ $data->iupjwa_nama_pemegang_izin }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="iupjwa_tahun_penerbitan_izin">Tahun Penerbitan Izin</label>
                                    <select class="form-control selectpicker" name="iupjwa_tahun_penerbitan_izin"
                                        required>
                                        @foreach($years as $year)
                                        <option value="{{ $year }}" {{ $data->iupjwa_tahun_penerbitan_izin == $year ?
                                            'selected' : '' }}>{{ $year }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="iupjwa_jenis_jasa">Jenis Jasa</label>
                                    <select class="selectpicker form-control" name="iupjwa_jenis_jasa" required>
                                        <option value="Jasa Transportasi" {{ $data->iupjwa_jenis_jasa === 'Jasa
                                            Transportasi' ? 'selected' : '' }}>Jasa Transportasi</option>
                                        <option value="Jasa Perjalanan Wisata" {{ $data->iupjwa_jenis_jasa === 'Jasa
                                            Perjalanan Wisata' ? 'selected' : '' }}>Jasa Perjalanan Wisata</option>
                                        <option value="Jasa Informasi Wisata" {{ $data->iupjwa_jenis_jasa === 'Jasa
                                            Informasi Wisata' ? 'selected' : '' }}>Jasa Informasi Wisata</option>
                                        <option value="Jasa Penyedia Makan/Minum" {{ $data->iupjwa_jenis_jasa === 'Jasa
                                            Penyedia Makan/Minum' ? 'selected' : '' }}>Jasa Penyedia Makan/Minum
                                        </option>
                                    </select>
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
@endpush