@extends('layouts.app')
@section('title', 'Penanganan Perkara Tindak Pidana')
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
                            <h3>Triwulan {{ $triwulan }}</h3>
                            <h4>Tambah Data Penanganan Perkara Tindak Pidana</h4>
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
                            <form action="{{ route('penanganan_perkara.store') }}" method="POST" id="permasalahan-form">
                                @csrf
                                <input type="hidden" name="triwulan" value="{{ $triwulan }}">
                                <div class="form-group">
                                    <label for="uraian_kasus">Uraian Kasus</label>
                                    <textarea class="form-control" id="uraian_kasus" name="uraian_kasus" rows="4"
                                        placeholder="Masukkan uraian kasus" required></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="tersangka">Tersangka</label>
                                    <input type="text" class="form-control" id="tersangka" name="tersangka"
                                        placeholder="Masukkan tersangka" required>
                                </div>
                                <div class="form-group">
                                    <label for="barang_bukti">Barang Bukti</label>
                                    <input type="text" class="form-control" id="barang_bukti" name="barang_bukti"
                                        placeholder="Masukkan barang bukti" required>
                                </div>
                                <div class="thick-hr"></div>
                                <h6>Proses Penanganan Perkara</h6>
                                <div class="form-group">
                                    <label for="lidik">Lidik</label>
                                    <select class="form-control" id="lidik" name="lidik" required>
                                        <option value="Nihil">Nihil</option>
                                        <option value="Iya">Iya</option>
                                        <option value="Tidak">Tidak</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="sidik">Sidik</label>
                                    <select class="form-control" id="sidik" name="sidik" required>
                                        <option value="Nihil">Nihil</option>
                                        <option value="Iya">Iya</option>
                                        <option value="Tidak">Tidak</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="sp3">SP3</label>
                                    <select class="form-control" id="sp3" name="sp3" required>
                                        <option value="Nihil">Nihil</option>
                                        <option value="Iya">Iya</option>
                                        <option value="Tidak">Tidak</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="p21">P21</label>
                                    <select class="form-control" id="p21" name="p21" required>
                                        <option value="Nihil">Nihil</option>
                                        <option value="Iya">Iya</option>
                                        <option value="Tidak">Tidak</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="vonis">Vonis</label>
                                    <select class="form-control" id="vonis" name="vonis" required>
                                        <option value="Nihil">Nihil</option>
                                        <option value="Iya">Iya</option>
                                        <option value="Tidak">Tidak</option>
                                    </select>
                                </div>
                                <hr>
                                <div class="form-group">
                                    <label for="keterangan">Keterangan</label>
                                    <textarea class="form-control" id="keterangan" name="keterangan" rows="3"
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