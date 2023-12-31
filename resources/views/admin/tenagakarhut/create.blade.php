@extends('layouts.app')

@section('title', 'Tambah Data Tenaga Pengendalian Kebakaran Hutan Triwulan ' . $triwulan)

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
                <div class="col-xl-12 col-md-12 col-sm-12 col-12 " style="margin-left: 12px;">
                    <br>
                    <h3>Triwulan {{ $triwulan }}</h3>
                    <h4>Tambah Data Tenaga Pengendalian Kebakaran Hutan</h4> <!-- Sudah diperbaiki -->
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
                    <form action="{{ route('tenagakarhut.store', ['triwulan' => $triwulan]) }}" method="POST"
                        id="tenagakarhut">
                        @csrf
                        <input type="hidden" name="triwulan" value="{{ $triwulan }}">
                        <div class="form-group">
                            <label for="manggala_agni_pns">Manggala Agni PNS (Orang)</label>
                            <input type="number" class="form-control" name="manggala_agni_pns" required>
                        </div>
                        <div class="form-group">
                            <label for="manggala_agni_nonpns">Manggala Agni Non PNS (Orang)</label>
                            <input type="number" class="form-control" name="manggala_agni_nonpns" required>
                        </div>
                        <div class="form-group">
                            <label for="jumlah_regu">Jumlah Regu</label>
                            <input type="number" class="form-control" name="jumlah_regu" required>
                        </div>
                        <div class="form-group">
                            <label for="mpa">MPA (Orang)</label>
                            <input type="number" class="form-control" name="mpa" required>
                        </div>
                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <textarea class="form-control" name="keterangan"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary mt-4" id="submit-button">Simpan</button>
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

@endpush