@extends('layouts.app')

@section('title', 'Peralatan Tranportasi Pengendalian Kebakaran Hutan ' . $semester)

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
                            <h3>Semester {{ $semester }}</h3>
                            <h4>Peralatan Tranportasi Pengendalian Kebakaran Hutan</h4>
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
                            <form action="{{ route('peralatantransportasi.store', ['semester' => $semester]) }}"
                                method="POST">
                                @csrf
                                <input type="hidden" name="semester" value="{{ $semester }}">
                                <div class="form-group">
                                    <label for="daops">Daops/Non Daops</label>
                                    <input type="text" class="form-control" name="daops"
                                        placeholder="Masukkan Daops/Non Daops" required>
                                </div>
                                <div class="thick-hr"></div>
                                <h6 style="text-align: center; line-height: 50px;  font-weight: bold;">Transportasi
                                    Darat (Unit)</h6>
                                <h6>Slip On Unit</h6>
                                <div class="form-group">
                                    <label for="baik1">Baik</label>
                                    <input type="number" class="form-control" name="baik1" placeholder="Masukkan Baik"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="rusak1">Rusak</label>
                                    <input type="number" class="form-control" name="rusak1" placeholder="Masukkan Rusak"
                                        required>
                                </div>
                                <h6>Monilog</h6>
                                <div class="form-group">
                                    <label for="baik2">Baik</label>
                                    <input type="number" class="form-control" name="baik2" placeholder="Masukkan Baik"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="rusak2">Rusak</label>
                                    <input type="number" class="form-control" name="rusak2" placeholder="Masukkan Rusak"
                                        required>
                                </div>
                                <h6>Sepeda Motor Patroli</h6>
                                <div class="form-group">
                                    <label for="baik3">Baik</label>
                                    <input type="number" class="form-control" name="baik3" placeholder="Masukkan Baik"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="rusak3">Rusak</label>
                                    <input type="number" class="form-control" name="rusak3" placeholder="Masukkan Rusak"
                                        required>
                                </div>
                                <h6>Mobil Patroli/Pick Up</h6>
                                <div class="form-group">
                                    <label for="baik4">Baik</label>
                                    <input type="number" class="form-control" name="baik4" placeholder="Masukkan Baik"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="rusak4">Rusak</label>
                                    <input type="number" class="form-control" name="rusak4" placeholder="Masukkan Rusak"
                                        required>
                                </div>
                                <h6>Mobil Operasional/ Pick Up</h6>
                                <div class="form-group">
                                    <label for="baik5">Baik</label>
                                    <input type="number" class="form-control" name="baik5" placeholder="Masukkan Baik"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="rusak5">Rusak</label>
                                    <input type="number" class="form-control" name="rusak5" placeholder="Masukkan Rusak"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="lain">Lain-Lain</label>
                                    <input type="number" class="form-control" name="lain1"
                                        placeholder="Masukkan Lain-Lain" required>
                                </div>
                                <div class="thick-hr"></div>
                                <h6 style="text-align: center; line-height: 50px;  font-weight: bold;">Transportasi Air
                                    (Unit)</h6>
                                <h6>Boat</h6>
                                <div class="form-group">
                                    <label for="baik6">Baik</label>
                                    <input type="number" class="form-control" name="baik6" placeholder="Masukkan Baik"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="rusak6">Rusak</label>
                                    <input type="number" class="form-control" name="rusak6" placeholder="Masukkan Rusak"
                                        required>
                                </div>
                                <h6>Klotok</h6>
                                <div class="form-group">
                                    <label for="baik7">Baik</label>
                                    <input type="number" class="form-control" name="baik7" placeholder="Masukkan Baik"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="rusak7">Rusak</label>
                                    <input type="number" class="form-control" name="rusak7" placeholder="Masukkan Rusak"
                                        required>
                                </div>
                                <h6>Katinting</h6>
                                <div class="form-group">
                                    <label for="baik8">Baik</label>
                                    <input type="number" class="form-control" name="baik8" placeholder="Masukkan Baik"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="rusak8">Rusak</label>
                                    <input type="number" class="form-control" name="rusak8" placeholder="Masukkan Rusak"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="lain2">Lain-Lain</label>
                                    <input type="number" class="form-control" name="lain2"
                                        placeholder="Masukkan Lain-Lain" required>
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