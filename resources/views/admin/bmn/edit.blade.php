@extends('layouts.app')

@section('title', 'Edit Rincian Barang Milik Negara (Semester ' . $semester . ')')

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
                            <h3>Edit Rincian Barang Milik Negara (Semester {{ $semester }})</h3>
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
                            <form action="{{ route('bmn.update', ['semester' => $semester, 'id' => $data->id]) }}"
                                method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="semester" value="{{ $semester }}">

                                <div class="thick-hr"></div>
                                <h6>Kelompok Barang</h6>
                                <div class="form-group">
                                    <label for="kode">Kode</label>
                                    <input type="number" class="form-control" name="kode" placeholder="Masukkan Kode"
                                        value="{{ $data->kode }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="uraian">Uraian</label>
                                    <input type="text" class="form-control" name="uraian" placeholder="Masukkan Uraian"
                                        value="{{ $data->uraian }}" required>
                                </div>
                                <div class="thick-hr"></div>
                                <div class="form-group">
                                    <label for="satuan">
                                        <h6>Satuan Barang</h6>
                                    </label>
                                    <input type="text" class="form-control" name="satuan"
                                        placeholder="Masukkan Satuan Barang" value="{{ $data->satuan }}" required>
                                </div>
                                <div class="thick-hr"></div>
                                <h6>Kondisi Sebelumnya</h6>
                                <div class="form-group">
                                    <label for="kuantitas1">Kuantitas</label>
                                    <input type="number" class="form-control" name="kuantitas1"
                                        placeholder="Masukkan Kuantitas" value="{{ $data->kuantitas1 }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="nilai1">Nilai (Rp)</label>
                                    <input type="number" class="form-control" name="nilai1"
                                        placeholder="Masukkan Nilai (Rp)" value="{{ $data->nilai1 }}" required>
                                </div>
                                <div class="thick-hr"></div>
                                <h6>Mutasi</h6>
                                <div class="thick-hr"></div>
                                <h6>Bertambah</h6>
                                <div class="form-group">
                                    <label for="kuantitas2">Kuantitas</label>
                                    <input type="number" class="form-control" name="kuantitas2"
                                        placeholder="Masukkan Kuantitas" value="{{ $data->kuantitas2 }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="nilai2">Nilai (Rp)</label>
                                    <input type="number" class="form-control" name="nilai2"
                                        placeholder="Masukkan Nilai (Rp)" value="{{ $data->nilai2 }}" required>
                                </div>
                                <h6>Berkurang</h6>
                                <div class="form-group">
                                    <label for="kuantitas3">Kuantitas</label>
                                    <input type="number" class="form-control" name="kuantitas3"
                                        placeholder="Masukkan Kuantitas" value="{{ $data->kuantitas3 }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="nilai3">Nilai (Rp)</label>
                                    <input type="number" class="form-control" name="nilai3"
                                        placeholder="Masukkan Nilai (Rp)" value="{{ $data->nilai3 }}" required>
                                </div>
                                <div class="thick-hr"></div>
                                <h6>Saldo Barang</h6>
                                <div class="thick-hr"></div>
                                <div class="form-group">
                                    <label for="kuantitas4">Kuantitas</label>
                                    <input type="number" class="form-control" name="kuantitas4"
                                        placeholder="Masukkan Kuantitas" value="{{ $data->kuantitas4 }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="nilai4">Nilai (Rp)</label>
                                    <input type="number" class="form-control" name="nilai4"
                                        placeholder="Masukkan Nilai (Rp)" value="{{ $data->nilai4 }}" required>
                                </div>
                                <hr>
                                <div class="form-group">
                                    <label for="keterangan">Keterangan</label>
                                    <textarea class="form-control" name="keterangan" rows="3"
                                        placeholder="Masukkan keterangan (Optional)">{{ $data->keterangan }}</textarea>
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