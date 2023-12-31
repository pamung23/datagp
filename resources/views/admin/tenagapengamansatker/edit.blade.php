@extends('layouts.app')

@section('title', 'Edit Data Tenaga Pengamanan Hutan Per Satuan Kerja')

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
                    <h4>Edit Data Tenaga Pengamanan Hutan Per Satuan Kerja</h4>
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
                        action="{{ route('tenagapengamansatker.update', ['triwulan' => $triwulan, 'id' => $data->id]) }}"
                        method="POST" id="tenaga-pengamanan-hutan-form">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="triwulan" value="{{ $triwulan }}">
                        <div class="form-group">
                            <label for="polhut">Polhut (Orang)</label>
                            <input type="number" class="form-control" id="polhut" name="polhut" required
                                value="{{ $data->polhut }}">
                        </div>
                        <div class="form-group">
                            <label for="ppns">PPNS (Orang)</label>
                            <input type="number" class="form-control" id="ppns" name="ppns" required
                                value="{{ $data->ppns }}">
                        </div>
                        <div class="form-group">
                            <label for="tphl">TPHL (Orang)</label>
                            <input type="number" class="form-control" id="tphl" name="tphl" required
                                value="{{ $data->tphl }}">
                        </div>
                        <div class="form-group">
                            <label for="mmp">MMP (Orang)</label>
                            <input type="number" class="form-control" id="mmp" name="mmp" required
                                value="{{ $data->mmp }}">
                        </div>
                        <div class="form-group">
                            <label for="keterangan">Keterangan:</label>
                            <textarea name="keterangan" class="form-control" rows="3">{{ $data->keterangan }}</textarea>
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