@extends('layouts.app')

@section('title', 'Edit Data Sebaran PNS/CPNS Menurut Tingkat Pendidikan dan Jenis Kelamin ' . $semester)

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
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12" style="margin-left: 12px;">
                            <br>
                            <h3>Semester {{ $semester }}</h3>
                            <h4>Edit Ekosistem Kawasan Konservasi </h4>
                        </div>
                    </div>
                </div>
                <div class="widget-content widget-content-area">
                    <div class="row">
                        <div class="col-lg-8 col-12 mx-auto">
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
                            <form action="{{ route('ekosistem.update', ['semester' => $semester, 'id' => $data->id]) }}"
                                method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="semester" value="{{ $semester }}">

                                <div class="form-group">
                                    <label for="tipe">Tipe Ekosistem</label>
                                    <select name="tipe" class="form-control" required>
                                        <option value="Hutan Dipterokarpa" {{ $data->tipe == 'Hutan Dipterokarpa' ?
                                            'selected' : '' }}>Hutan Dipterokarpa</option>
                                        <option value="Hutan Karangas" {{ $data->tipe == 'Hutan Karangas' ? 'selected' :
                                            '' }}>Hutan Karangas</option>
                                        <option value="Rawa" {{ $data->tipe == 'Rawa' ? 'selected' : '' }}>Rawa</option>
                                        <option value="Rawa Gambut" {{ $data->tipe == 'Rawa Gambut' ? 'selected' : ''
                                            }}>Rawa Gambut</option>
                                        <option value="Karst Dan Gua" {{ $data->tipe == 'Karst Dan Gua' ? 'selected' :
                                            '' }}>Karst Dan Gua</option>
                                        <option value="Savana" {{ $data->tipe == 'Savana' ? 'selected' : '' }}>Savana
                                        </option>
                                        <option value="Hutan Pegunungan Bawah" {{ $data->tipe == 'Hutan Pegunungan
                                            Bawah' ? 'selected' : '' }}>Hutan Pegunungan Bawah</option>
                                        <option value="Hutan Pegunungan Atas" {{ $data->tipe == 'Hutan Pegunungan Atas'
                                            ? 'selected' : '' }}>Hutan Pegunungan Atas</option>
                                        <option value="Hutan Sub Alpin" {{ $data->tipe == 'Hutan Sub Alpin' ? 'selected'
                                            : '' }}>Hutan Sub Alpin</option>
                                        <option value="Hutan Alpin" {{ $data->tipe == 'Hutan Alpin' ? 'selected' : ''
                                            }}>Hutan Alpin</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="luas">Luas Ekosistem</label>
                                    <input type="string" name="luas" class="form-control" pattern="[0-9]+([\.,][0-9]+)?"
                                        title="Masukkan angka desimal dengan menggunakan tanda titik sebagai pemisah"
                                        required value="{{ $data->luas }}">
                                </div>
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