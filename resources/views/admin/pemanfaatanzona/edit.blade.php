@extends('layouts.app')

@section('title', 'Edit Data Pemanfaatan Zona Blok')

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
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                            <h4>Edit Data Pemanfaatan Zona Blok</h4>
                        </div>
                    </div>
                </div>
                <div class="widget-content widget-content-area">
                    <div class="row">
                        <div class="col-lg-6 col-12 mx-auto">
                            <form action="{{ route('pemanfaatanzona.update', $pemanfaatanZonaBlok->id) }}"
                                method="POST">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="id_desa">Desa:</label>
                                    <select name="id_desa" class="form-control" required>
                                        <option value="">Pilih Desa</option>
                                        @foreach($desas as $desa)
                                        <option value="{{ $desa->id }}" {{ $pemanfaatanZonaBlok->id_desa == $desa->id ?
                                            'selected' : '' }}>
                                            {{ $desa->desa }}</option>
                                        @endforeach
                                    </select>
                                    @error('id_desa')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="nama_kelompok">Nama Kelompok</label>
                                    <input type="text" class="form-control" id="nama_kelompok" name="nama_kelompok"
                                        value="{{ $pemanfaatanZonaBlok->nama_kelompok }}" required>
                                    @error('nama_kelompok')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="anggota">Anggota (Orang)</label>
                                    <input type="number" class="form-control" id="anggota" name="anggota"
                                        value="{{ $pemanfaatanZonaBlok->anggota }}" required>
                                    @error('anggota')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="luas">Luas PKS (Ha)</label>
                                    <input type="number" class="form-control" id="luas" name="luas"
                                        value="{{ $pemanfaatanZonaBlok->luas }}" required>
                                    @error('luas')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="potensi">Potensi yang Dimanfaatkan</label>
                                    <input type="text" class="form-control" id="potensi" name="potensi"
                                        value="{{ $pemanfaatanZonaBlok->potensi }}" required>
                                    @error('potensi')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="nilai_ekonomi_per_tahun">Perkiraan Nilai Ekonomi per Tahun (Rp)</label>
                                    <input type="number" class="form-control" id="nilai_ekonomi_per_tahun"
                                        name="nilai_ekonomi_per_tahun"
                                        value="{{ $pemanfaatanZonaBlok->nilai_ekonomi_per_tahun }}">
                                    @error('nilai_ekonomi_per_tahun')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="keterangan">Keterangan (Opsional)</label>
                                    <input type="text" class="form-control" id="keterangan" name="keterangan"
                                        value="{{ $pemanfaatanZonaBlok->keterangan }}">
                                    @error('keterangan')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                    @enderror
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