@extends('layouts.app')

@section('title', 'Sarana Pengamanan Hutan ' . $semester)

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
                            <h4>Sarana Pengamanan Hutan</h4>
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
                            <form action="{{ route('saranapengamatan.store', ['semester' => $semester]) }}"
                                method="POST">
                                @csrf
                                <input type="hidden" name="semester" value="{{ $semester }}">

                                <h6>Senjata Api (Buah)</h6>
                                <div class="form-group">
                                    <label for="genggam">Genggam</label>
                                    <input type="number" class="form-control" name="genggam"
                                        placeholder="Masukkan Genggam" required>
                                </div>
                                <div class="form-group">
                                    <label for="laras_panjang">Laras Panjang</label>
                                    <input type="number" class="form-control" name="laras_panjang"
                                        placeholder="Masukkan Laras Panjang" required>
                                </div>
                                <div class="form-group">
                                    <label for="senjata_bius">Senjata Bius</label>
                                    <input type="number" class="form-control" name="senjata_bius"
                                        placeholder="Masukkan Senjata Bius" required>
                                </div>
                                <div class="form-group">
                                    <label for="lain1">Lain-Lain</label>
                                    <input type="number" class="form-control" name="lain1"
                                        placeholder="Masukkan Lain-Lain" required>
                                </div>
                                <div class="thick-hr"></div>
                                <h6>Alat Tranformasi (Unit)</h6>
                                <div class="form-group">
                                    <label for="mobil">Mobil</label>
                                    <input type="number" class="form-control" name="mobil" placeholder="Masukkan Mobil"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="spd_motor">Sepeda Motor</label>
                                    <input type="number" class="form-control" name="spd_motor"
                                        placeholder="Masukkan Sepeda Motor" required>
                                </div>
                                <div class="form-group">
                                    <label for="speed_boat">Speed Boat</label>
                                    <input type="number" class="form-control" name="speed_boat"
                                        placeholder="Masukkan Speed Boat" required>
                                </div>
                                <div class="form-group">
                                    <label for="perahu">Perahu/Kapal</label>
                                    <input type="number" class="form-control" name="perahu"
                                        placeholder="Masukkan Perahu/Kapal" required>
                                </div>
                                <div class="form-group">
                                    <label for="pesawat">Pesawat Trike</label>
                                    <input type="number" class="form-control" name="pesawat"
                                        placeholder="Masukkan Pesawat Trike" required>
                                </div>
                                <div class="form-group">
                                    <label for="lain2">Lain-Lain</label>
                                    <input type="number" class="form-control" name="lain2"
                                        placeholder="Masukkan Lain-Lain" required>
                                </div>
                                <div class="thick-hr"></div>
                                <h6>Alat Komunikasi (Unit)</h6>
                                <div class="form-group">
                                    <label for="rick">RICK</label>
                                    <input type="number" class="form-control" name="rick" placeholder="Masukkan RICK"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="ht">HT</label>
                                    <input type="number" class="form-control" name="ht" placeholder="Masukkan HT"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="ssb">SSB</label>
                                    <input type="number" class="form-control" name="ssb" placeholder="Masukkan SSB"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="lain3">Lain-Lain</label>
                                    <input type="number" class="form-control" name="lain3"
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