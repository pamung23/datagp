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
                            <h4>Penanganan Jenis Asing Invasif (IAS) di Kawasan Konservasi</h4>
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
                            <form action="{{ route('penangananjenis.store', ['semester' => $semester]) }}"
                                method="POST">
                                @csrf
                                <input type="hidden" name="semester" value="{{ $semester }}">

                                <div class="thick-hr"></div>
                                <h6>Jenis Invasif</h6>
                                <div class="thick-hr"></div>
                                <div class="form-group">
                                    <label for="ilmiah">Nama Ilmiah</label>
                                    <input type="text" class="form-control" name="ilmiah"
                                        placeholder="Masukkan Nama Ilmiah " required>
                                </div>
                                <div class="thick-hr"></div>
                                <h6>Luas (Ha)</h6>
                                <div class="form-group">
                                    <label for="luas">Luas (Ha)</label>
                                    <input type="number" class="form-control" name="luas"
                                        placeholder="Masukkan Luas (Ha)" required>
                                </div>
                                <div class="thick-hr"></div>
                                <h6>Koordinat Geografis (Decimal Degrees)</h6>
                                <div class="thick-hr"></div>
                                <div class="form-group">
                                    <label for="latitude">Latitude</label>
                                    <input type="number" class="form-control" name="latitude"
                                        placeholder="Masukkan Latitude" required>
                                </div>
                                <div class="form-group">
                                    <label for="longitude">Longitude</label>
                                    <input type="number" class="form-control" name="longitude"
                                        placeholder="Masukkan Longitude" required>
                                </div>
                                <div class="thick-hr"></div>
                                <h6>Penanganan yang sudah dilakukan</h6>
                                <div class="form-group">
                                    <label for="penanganan">Penanganan yang sudah dilakukan</label>
                                    <input type="text" class="form-control" name="penanganan"
                                        placeholder="Masukkan Penanganan yang sudah dilakukan" required>
                                </div>
                                <div class="thick-hr"></div>
                                <h6>Rencana Penanganan</h6>
                                <div class="form-group">
                                    <label for="rencana">Rencana Penanganan</label>
                                    <input type="text" class="form-control" name="rencana"
                                        placeholder="Masukkan Rencana Penanganan" required>
                                </div>
                                <div class="thick-hr"></div>
                                <h6>Kemitraan yang dilakukan</h6>
                                <div class="form-group">
                                    <label for="kemitraan">kemitraan</label>
                                    <input type="text" class="form-control" name="kemitraan"
                                        placeholder="Masukkan Kemitraan yang dilakukan " required>
                                </div>
                                <hr>
                                <div class="form-group">
                                    <label for="keterangan">Keterangan</label>
                                    <textarea class="form-control" name="keterangan" rows="3"
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