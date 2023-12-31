@extends('layouts.app')

@section('title', 'Edit Data Sebaran PNS/CPNS Menurut Tingkat Pendidikan dan Jenis Kelamin - Semester ' . $semester)

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
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                            <h3>Semester {{ $semester }}</h3>
                            <h4>Edit Data Sebaran PNS/CPNS Menurut Tingkat Pendidikan dan Jenis Kelamin</h4>
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
                            <form
                                action="{{ route('pegawaipendidikan.update', ['semester' => $semester, 'id' => $data->id]) }}"
                                method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="semester" value="{{ $semester }}">

                                <h6>Doktor</h6>
                                <div class="form-group">
                                    <label for="laki_doktor">Laki Doktor</label>
                                    <input type="number" class="form-control" name="laki_doktor"
                                        placeholder="Masukkan Laki Doktor" value="{{ $data->laki_doktor }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="perempuan_doktor">Perempuan Doktor</label>
                                    <input type="number" class="form-control" name="perempuan_doktor"
                                        placeholder="Masukkan Perempuan Doktor" value="{{ $data->perempuan_doktor }}"
                                        required>
                                </div>
                                <div class="thick-hr"></div>
                                <h6>Master</h6>
                                <div class="form-group">
                                    <label for="laki_master">Laki Master</label>
                                    <input type="number" class="form-control" name="laki_master"
                                        placeholder="Masukkan Laki Master" value="{{ $data->laki_master }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="perempuan_master">Perempuan Master</label>
                                    <input type="number" class="form-control" name="perempuan_master"
                                        placeholder="Masukkan Perempuan Master" value="{{ $data->perempuan_master }}"
                                        required>
                                </div>
                                <div class="thick-hr"></div>
                                <h6>Sarjana</h6>
                                <div class="form-group">
                                    <label for="laki_sarjana">Laki Sarjana</label>
                                    <input type="number" class="form-control" name="laki_sarjana"
                                        placeholder="Masukkan Laki Sarjana" value="{{ $data->laki_sarjana }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="perempuan_sarjana">Perempuan Sarjana</label>
                                    <input type="number" class="form-control" name="perempuan_sarjana"
                                        placeholder="Masukkan Perempuan Sarjana" value="{{ $data->perempuan_sarjana }}"
                                        required>
                                </div>
                                <div class="thick-hr"></div>
                                <h6>Sarjana Muda</h6>
                                <div class="form-group">
                                    <label for="laki_sarjana_muda">Laki Sarjana Muda</label>
                                    <input type="number" class="form-control" name="laki_sarjana_muda"
                                        placeholder="Masukkan Laki Sarjana Muda" value="{{ $data->laki_sarjana_muda }}"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="perempuan_sarjana_muda">Perempuan Sarjana Muda</label>
                                    <input type="number" class="form-control" name="perempuan_sarjana_muda"
                                        placeholder="Masukkan Perempuan Sarjana Muda"
                                        value="{{ $data->perempuan_sarjana_muda }}" required>
                                </div>
                                <div class="thick-hr"></div>
                                <h6>SLTA</h6>
                                <div class="form-group">
                                    <label for="laki_slta">Laki SLTA</label>
                                    <input type="number" class="form-control" name="laki_slta"
                                        placeholder="Masukkan Laki SLTA" value="{{ $data->laki_slta }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="perempuan_SLTA">Perempuan SLTA</label>
                                    <input type="number" class="form-control" name="perempuan_slta"
                                        placeholder="Masukkan Perempuan SLTA" value="{{ $data->perempuan_slta }}"
                                        required>
                                </div>
                                <div class="thick-hr"></div>
                                <h6>SLTP</h6>
                                <div class="form-group">
                                    <label for="laki_sltp">Laki SLTP</label>
                                    <input type="number" class="form-control" name="laki_sltp"
                                        placeholder="Masukkan Laki SLTP" value="{{ $data->laki_sltp }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="perempuan_sltp">Perempuan SLTP</label>
                                    <input type="number" class="form-control" name="perempuan_sltp"
                                        placeholder="Masukkan Perempuan SLTP" value="{{ $data->perempuan_sltp }}"
                                        required>
                                </div>
                                <div class="thick-hr"></div>
                                <h6>SD</h6>
                                <div class="form-group">
                                    <label for="laki_sd">Laki SD</label>
                                    <input type="number" class="form-control" name="laki_sd"
                                        placeholder="Masukkan Laki SD" value="{{ $data->laki_sd }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="perempuan_sd">Perempuan SD</label>
                                    <input type="number" class="form-control" name="perempuan_sd"
                                        placeholder="Masukkan Perempuan SD" value="{{ $data->perempuan_sd }}" required>
                                </div>
                                <div class="thick-hr"></div>
                                <h6>Jumlah</h6>
                                <div class="form-group">
                                    <label for="laki_jumlah">Laki Jumlah</label>
                                    <input type="number" class="form-control" name="laki_jumlah"
                                        placeholder="Masukkan Laki Jumlah" value="{{ $data->laki_jumlah }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="perempuan_jumlah">Perempuan Jumlah</label>
                                    <input type="number" class="form-control" name="perempuan_jumlah"
                                        placeholder="Masukkan Perempuan Jumlah" value="{{ $data->perempuan_jumlah }}"
                                        required>
                                </div>
                                <div class="thick-hr"></div>
                                <h6>Total</h6>
                                <div class="form-group">
                                    <label for="total">Total</label>
                                    <input type="number" class="form-control" name="total" placeholder="Masukkan Total"
                                        value="{{ $data->total }}" required>
                                </div>
                                <hr>
                                <div class="form-group">
                                    <label for="keterangan">Keterangan</label>
                                    <textarea class="form-control" name="keterangan" rows="3"
                                        placeholder="Masukkan keterangan (Optional)">{{ $data ->keterangan }}</textarea>
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