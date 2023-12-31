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
        <div id="basic" class="col-lg-12 layout-spacing">
            <div class="statbox widget box box-shadow">
                <div class="widget-header">
                    <div class="row">
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12" style="margin-left: 12px;">
                            <br>
                            <h3>Edit Data Triwulan {{ $triwulan }}</h3>
                            <h4>Edit Pembinaan Usaha Ekonomi Produktif pada Daerah Penyangga Kawasan Konservasi</h4>
                        </div>
                    </div>
                </div>
                <div class="widget-content widget-content-area">
                    <div class="row">
                        <div class="col-lg-6 col-12 mx-auto">
                            <form
                                action="{{ route('pembinaanusaha.update', ['triwulan' => $triwulan, 'id' => $data->id]) }}"
                                method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="triwulan" value="{{ $triwulan }}">
                                <div class="form-group">
                                    <label for="nama_kelompok">Nama Kelompok:</label>
                                    <input type="text" name="nama_kelompok" class="form-control"
                                        placeholder="Nama Kelompok" required value="{{ $data->nama_kelompok }}">
                                </div>
                                <div class="form-group">
                                    <label for="anggota">Jumlah Anggota:</label>
                                    <input type="number" name="anggota" class="form-control" required
                                        value="{{ $data->anggota }}">
                                </div>
                                <div class="form-group">
                                    <label for="jenis_kegiatan">Jenis Kegiatan:</label>
                                    <input type="text" name="jenis_kegiatan" class="form-control" required
                                        value="{{ $data->jenis_kegiatan }}">
                                </div>
                                <div class="form-group">
                                    <label for="jumlah_dana">Jumlah Dana (Rp):</label>
                                    <input type="text" name="jumlah_dana" class="form-control" required
                                        value="{{ number_format($data->jumlah_dana, 0, '', '') }}">
                                </div>
                                <div class="form-group">
                                    <label for="sumber_dana">Sumber Dana:</label>
                                    <input type="text" name="sumber_dana" class="form-control" required
                                        value="{{ $data->sumber_dana }}">
                                </div>
                                <div class="form-group">
                                    <label for="hasil_manfaat">Hasil dan Manfaat:</label>
                                    <input type="text" name="hasil_manfaat" class="form-control" required
                                        value="{{ $data->hasil_manfaat }}">
                                </div>
                                <div class="form-group">
                                    <label for="pendamping">Pendamping:</label>
                                    <input type="text" name="pendamping" class="form-control" required
                                        value="{{ $data->pendamping }}">
                                </div>
                                <div class="form-group">
                                    <label for="keterangan">Keterangan</label>
                                    <textarea class="form-control" id="keterangan"
                                        name="keterangan">{{ $data->keterangan }}</textarea>
                                </div>
                                <button type="submit" class="btn btn-primary mt-4">Simpan Perubahan</button>
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