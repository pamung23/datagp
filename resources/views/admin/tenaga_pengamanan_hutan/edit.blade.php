@extends('layouts.app')

@section('title', 'Edit Data Tenaga Pengamanan Hutan pada Kawasan Konservasi')

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
                            <h4>Edit Tenaga Pengamanan Hutan pada Kawasan Konservasi</h4>
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
                            <form
                                action="{{ route('tenaga_pengamanan_hutan.update', ['triwulan' => $triwulan, 'id' => $data->id]) }}"
                                method="POST" id="tenaga-pengamanan-hutan-form">
                                @csrf
                                @method('PUT') {{-- Menandakan bahwa ini adalah metode PUT untuk pembaruan --}}
                                <div class="form-group">
                                    <label for="polhut">Polhut (Orang)</label>
                                    <input type="number" class="form-control" id="polhut" name="polhut"
                                        value="{{ $data->polhut }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="ppns">PPNS (Orang)</label>
                                    <input type="number" class="form-control" id="ppns" name="ppns"
                                        value="{{ $data->ppns }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="tphl">TPHL (Orang)</label>
                                    <input type="number" class="form-control" id="tphl" name="tphl"
                                        value="{{ $data->tphl }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="mmp">MMP (Orang)</label>
                                    <input type="number" class="form-control" id="mmp" name="mmp"
                                        value="{{ $data->mmp }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="keterangan">Keterangan</label>
                                    <textarea class="form-control" id="keterangan" name="keterangan" rows="3"
                                        placeholder="Masukkan keterangan (Optional)">{{ $data->keterangan }}</textarea>
                                </div>
                                <button type="submit" class="btn btn-primary mt-4" id="submit-button">Simpan
                                    Perubahan</button>
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