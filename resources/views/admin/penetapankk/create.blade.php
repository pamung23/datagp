@extends('layouts.app')
@section('title', 'Tambah Data Kawasan Konservasi ' . $triwulan)
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
                            <h4>Tambah Data Kawasan Konservasi</h4>
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
                            <form action="{{ route('penetapankk.store', ['triwulan' => $triwulan]) }}" method="POST">
                                @csrf
                                <input type="hidden" name="triwulan" value="{{ $triwulan }}">

                                <h6>Penunjukkan Parsial</h6>
                                <div class="form-group">
                                    <label for="nomor_sk_parsial">Nomor SK Parsial</label>
                                    <input type="text" class="form-control" name="nomor_sk_parsial" required>
                                </div>
                                <div class="form-group">
                                    <label for="tanggal_sk_parsial">Tanggal SK Parsial</label>
                                    <input id="basicFlatpickr1" class="form-control flatpickr flatpickr-input "
                                        type="text" placeholder="Pilih Tanggal.." id="tanggal_sk_parsial"
                                        name="tanggal_sk_parsial" required>
                                </div>
                                <div class="form-group">
                                    <label for="luas_ha_parsial">Luas (ha) Parsial</label>
                                    <input type="text" name="luas_ha_parsial" class="form-control" pattern="[-.,\d]+"
                                        onkeypress="return event.charCode >= 48 && event.charCode <= 57 || event.charCode === 44 || event.charCode === 46"
                                        required>
                                </div>
                                <div class="thick-hr"></div>
                                <h6>Penunjukkan Per Provinsi</h6>
                                <div class="form-group">
                                    <label for="nomor_sk_provinsi">Nomor SK Provinsi</label>
                                    <input type="text" class="form-control" name="nomor_sk_provinsi" required>
                                </div>
                                <div class="form-group">
                                    <label for="tanggal_sk_provinsi">Tanggal SK Provinsi</label>
                                    <input id="basicFlatpickr2" class="form-control flatpickr flatpickr-input "
                                        type="text" placeholder="Pilih Tanggal.." id="tanggal_sk_provinsi"
                                        name="tanggal_sk_provinsi" required>
                                </div>
                                <div class="form-group">
                                    <label for="luas_ha_provinsi">Luas (ha) Provinsi</label>
                                    <input type="text" class="form-control" name="luas_ha_provinsi" pattern="[-.,\d]+"
                                        onkeypress="return event.charCode >= 48 && event.charCode <= 57 || event.charCode === 44 || event.charCode === 46"
                                        required>
                                </div>
                                <div class="thick-hr"></div>
                                <h6>Penetapan Kawasan</h6>
                                <div class="form-group">
                                    <label for="nomor_sk_kawasan">Nomor SK Kawasan</label>
                                    <input type="text" class="form-control" name="nomor_sk_kawasan" required>
                                </div>
                                <div class="form-group">
                                    <label for="tanggal_sk_kawasan">Tanggal SK Kawasan</label>
                                    <input id="basicFlatpickr3" class="form-control flatpickr flatpickr-input "
                                        type="text" placeholder="Pilih Tanggal.." id="tanggal_sk_kawasan"
                                        name="tanggal_sk_kawasan" required>
                                </div>
                                <div class="form-group">
                                    <label for="luas_ha_kawasan">Luas (ha) Kawasan</label>
                                    <input type="text" class="form-control" name="luas_ha_kawasan" pattern="[-.,\d]+"
                                        onkeypress="return event.charCode >= 48 && event.charCode <= 57 || event.charCode === 44 || event.charCode === 46"
                                        required>

                                </div>
                                <div class="form-group">
                                    <label for="keterangan">Keterangan</label>
                                    <textarea class="form-control" name="keterangan"></textarea>
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
<script>
    var f1 = flatpickr(document.getElementById('basicFlatpickr1'));
    var f1 = flatpickr(document.getElementById('basicFlatpickr2'));
    var f1 = flatpickr(document.getElementById('basicFlatpickr3'));
</script>
<script>
    // Menggunakan event listener untuk mendengarkan input pada field dengan nama 'luas_ha_parsial'
    document.addEventListener("DOMContentLoaded", function() {
        var luasHaInputs = document.querySelectorAll('input[name="luas_ha_parsial"], input[name="luas_ha_provinsi"], input[name="luas_ha_kawasan"]');
        luasHaInputs.forEach(function(input) {
            input.addEventListener('input', function() {
                // Mengganti koma dengan titik pada input
                var parsed = this.value.replace(',', '.');
                this.value = parsed;
            });
        });
    });
</script>
@endpush