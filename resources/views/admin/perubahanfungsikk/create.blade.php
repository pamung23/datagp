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
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12 " style="margin-left: 12px;">
                            <br>
                            <h3>Semester {{ $semester }}</h3>
                            <h4>Tambah Perubahan Fungsi dan Perubahan Peruntukan Kawasan Konservasi</h4>
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
                            <form action="{{ route('perubahanfungsikk.store', ['semester' => $semester]) }}"
                                method="POST">
                                @csrf
                                <input type="hidden" name="semester" value="{{ $semester }}">
                                <h6>Penunjukan/Penetapan Awal</h6>
                                <div class="form-group">
                                    <label for="nomor1">Nomor SK</label>
                                    <input type="text" class="form-control" name="nomor1"
                                        placeholder="Masukkan Nomor SK" required>
                                </div>
                                <div class="form-group">
                                    <label for="tanggal2">Tanggal SK</label>
                                    <input id="basicFlatpickr" class="form-control flatpickr flatpickr-input "
                                        type="text" placeholder="Pilih Tanggal.." id="tanggal2" name="tanggal2"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="luas1">Luas (Ha)</label>
                                    <input type="text" class="form-control" name="luas1"
                                        placeholder="Masukkan Luas (Ha)" required>
                                </div>
                                <div class="thick-hr"></div>
                                <h6>Perubahan Fungsi/Peruntukan</h6>
                                <div class="form-group">
                                    <label for="nomor2">Nomor SK</label>
                                    <input type="text" class="form-control" name="nomor2"
                                        placeholder="Masukkan Nomor SK" required>
                                </div>
                                <div class="form-group">
                                    <label for="tanggal1">Tanggal SK</label>
                                    <input id="basicFlatpickr1" class="form-control flatpickr flatpickr-input "
                                        type="text" placeholder="Pilih Tanggal.." id="tanggal1" name="tanggal1"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="luas2">Luas (Ha)</label>
                                    <input type="tesxt" class="form-control" name="luas2"
                                        placeholder="Masukkan Luas (Ha)" required>
                                </div>
                                <div class="thick-hr"></div>
                                <h6>Kondisi Akhir</h6>
                                <div class="form-group">
                                    <label for="fungsi">Fungsi Kawasan</label>
                                    <input type="text" class="form-control" name="fungsi"
                                        placeholder="Masukkan Fungsi Kawasan" required>
                                </div>
                                <div class="form-group">
                                    <label for="nama">Nama Kawasan Konservasi</label>
                                    <input type="text" class="form-control" name="nama"
                                        placeholder="Masukkan Nama Kawasan Konservasi" required>
                                </div>
                                <div class="form-group">
                                    <label for="luas3">Luas (Ha)</label>
                                    <input type="text" class="form-control" name="luas3"
                                        placeholder="Masukkan Luas (Ha)" required>
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
<script>
    var f1 = flatpickr(document.getElementById('basicFlatpickr1'));
    var f1 = flatpickr(document.getElementById('basicFlatpickr2'));
    var f1 = flatpickr(document.getElementById('basicFlatpickr3'));
</script>
@endpush