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
        margin: 10px 0;
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
                            <h4>Edit Data Rekontruksi Batas Kawasan Konservasi</h4>
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
                                action="{{ route('rekontruksibatas.update', ['semester' => $semester, 'id' => $data->id]) }}"
                                method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="semester" value="{{ $semester }}">
                                <div class="form-group">
                                    <label for="p_batas">Panjang Batas (KM)</label>
                                    <input type="text" class="form-control" name="p_batas" value="{{ $data->p_batas }}"
                                        placeholder=" Masukkan Panjang Batas " required>
                                </div>
                                <div class="thick-hr"></div>
                                <h6>Realisasi Tata Batas</h6>
                                <div class="form-group">
                                    <label for="tahun">Tahun</label>
                                    <select class="form-control selectpicker" name="tahun" required>
                                        <option value="">Pilih Tahun</option>
                                        @foreach($years as $year)
                                        <option value="{{ $year }}" {{ $data->tahun == $year ? 'selected' : '' }}>
                                            {{ $year }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="panjang">Panjang (KM)</label>
                                    <input type="text" class="form-control" name="panjang" value="{{ $data->panjang }}"
                                        placeholder="Masukkan Panjang" required>
                                </div>
                                <div class="form-group">
                                    <label for="jmlh_batas">Jumlah Pal Batas</label>
                                    <input type="text" class="form-control" name="jmlh_batas"
                                        value="{{ $data->jmlh_batas }}" placeholder="Masukkan Jumlah Pal Batas"
                                        required>
                                </div>
                                <div class="thick-hr"></div>
                                <h6>Berita Acara/Laporan Rekonstruksi Batas</h6>
                                <div class="form-group">
                                    <label for="nomor">Nomor</label>
                                    <input type="text" class="form-control" name="nomor" placeholder="Masukkan Nomor"
                                        value="{{ $data->nomor }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="tanggal">Tanggal</label>
                                    <input id="basicFlatpickr" class="form-control flatpickr flatpickr-input "
                                        value="{{ $data->tanggal }}" type="text" placeholder="Pilih Tanggal.."
                                        id="tanggal" name="tanggal" required>
                                </div>
                                <hr>
                                <div class="form-group">
                                    <label for="keterangan">Keterangan</label>
                                    <textarea class="form-control" name="keterangan" rows="3"
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