@extends('layouts.app')

@section('title', 'Create Data Perizinan Pemanfaatan Jasa Lingkungan')

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
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12 " style="margin-left: 12px;">
                            <br>
                            <h3>Triwulan {{ $triwulan }}</h3>
                            <h4>Create Data Perizinan Pemanfaatan Jasa Lingkungan</h4>
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
                            <form action="{{ route('jasling.store', ['triwulan' => $triwulan]) }}" method="POST">
                                @csrf
                                <input type="hidden" name="triwulan" value="{{ $triwulan }}">
                                <div class="form-group">
                                    <label for="iupswa">IUPSWA</label>
                                    <input type="number" class="form-control" name="iupswa" value="{{ old('iupjwa') }}"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="iupjwa">IUPJWA</label>
                                    <input type="number" class="form-control" name="iupjwa" value="{{ old('iupjwa') }}"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="iupa">IUPA</label>
                                    <input type="number" class="form-control" name="iupa" value="{{ old('iupa') }}"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="iupea">IUPEA</label>
                                    <input type="number" class="form-control" name="iupea" value="{{ old('iupea') }}"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="ipa">IPA</label>
                                    <input type="number" class="form-control" name="ipa" value="{{ old('ipa') }}"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="ipea">IPEA</label>
                                    <input type="number" class="form-control" name="ipea" value="{{ old('ipea') }}"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="ipjlpb_eksplorasi">IPJLPB Eksplorasi</label>
                                    <input type="number" class="form-control" name="ipjlpb_eksplorasi"
                                        value="{{ old('ipjlpb_eksplorasi') }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="ipjlpb_eksplorasi_pemanfaatan">IPJLPB Eksplorasi dan Pemanfaatan</label>
                                    <input type="number" class="form-control" name="ipjlpb_eksplorasi_pemanfaatan"
                                        value="{{ old('ipjlpb_eksplorasi_pemanfaatan') }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="keterangan">Keterangan</label>
                                    <textarea class="form-control" name="keterangan" rows="3"
                                        placeholder="Masukkan keterangan (Optional)"></textarea>
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