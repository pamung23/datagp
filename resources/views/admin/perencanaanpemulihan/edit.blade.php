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
                            <h4>Perencanaan Pemulihan Ekosistem Kawasan Konservasi</h4>
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
                            <form action="{{ route('perencanaanpemulihan.update', $perencanaanPemulihan->id) }}"
                                method="POST">
                                @csrf
                                @method('PUT')
                                <!-- Untuk metode HTTP PUT -->
                                <div class="form-group">
                                    <label for="tahun_dokumen_rpe">Tahun Dokumen RPE:</label>
                                    <input type="text" name="tahun_dokumen_rpe" class="form-control"
                                        placeholder="Tahun Dokumen RPE"
                                        value="{{ $perencanaanPemulihan->tahun_dokumen_rpe }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="metode_pe">Metode Pemulihan Ekosistem</label>
                                    <select name="metode_pe" class="form-control" required>
                                        <option value="Suksesi Alami" {{ $perencanaanPemulihan->metode_pe === 'Suksesi
                                            Alami' ?
                                            'selected' : '' }}>Suksesi Alami</option>
                                        <option value="Rehabilitasi" {{ $perencanaanPemulihan->metode_pe ===
                                            'Rehabilitasi' ? 'selected'
                                            : '' }}>Rehabilitasi</option>
                                        <option value="Restorasi" {{ $perencanaanPemulihan->metode_pe === 'Restorasi' ?
                                            'selected' : ''
                                            }}>Restorasi</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="target_pe">Target PE:</label>
                                    <input type="number" name="target_pe" class="form-control" step="0.01"
                                        placeholder="Target PE" value="{{ $perencanaanPemulihan->target_pe }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="keterangan">Keterangan:</label>
                                    <input type="text" name="keterangan" class="form-control" placeholder="Keterangan"
                                        value="{{ $perencanaanPemulihan->keterangan }}">
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