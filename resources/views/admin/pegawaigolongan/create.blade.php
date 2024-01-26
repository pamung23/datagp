@extends('layouts.app')

@section('title', 'Tambah Data Sebaran PNS/CPNS Menurut Tingkat golongan dan Jenis Kelamin ' . $semester)

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
                            <h4>Tambah Data Sebaran PNS/CPNS Menurut Golongan dan Jenis Kelamin</h4>
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
                            <form action="{{ route('pegawaigolongan.store', ['semester' => $semester]) }}"
                                method="POST">
                                @csrf
                                <input type="hidden" name="semester" value="{{ $semester }}">
                                <h6>Golongan IV</h6>
                                <div class="form-group">
                                    <label for="laki_iv">Laki IV</label>
                                    <input type="number" class="form-control" name="laki_iv" oninput="hitungTotal()"
                                        placeholder="Masukkan Jumlah Laki-laki" required>
                                </div>
                                <div class="form-group">
                                    <label for="perempuan_iv">Perempuan IV</label>
                                    <input type="number" class="form-control" name="perempuan_iv"
                                        oninput="hitungTotal()" placeholder="Masukkan Jumlah Perempuan" required>
                                </div>
                                <div class="thick-hr"></div>
                                <h6>Golongan III</h6>
                                <div class="form-group">
                                    <label for="laki_iii">Laki-laki</label>
                                    <input type="number" class="form-control" name="laki_iii" oninput="hitungTotal()"
                                        placeholder="Masukkan Jumlah Laki-laki" required>
                                </div>
                                <div class="form-group">
                                    <label for="perempuan_iii">Perempuan</label>
                                    <input type="number" class="form-control" name="perempuan_iii"
                                        oninput="hitungTotal()" placeholder="Masukkan Jumlah Perempuan" required>
                                </div>
                                <div class="thick-hr"></div>
                                <h6>Golongan II</h6>
                                <div class="form-group">
                                    <label for="laki_ii">Laki-laki</label>
                                    <input type="number" class="form-control" name="laki_ii" oninput="hitungTotal()"
                                        placeholder="Masukkan Jumlah Laki-laki" required>
                                </div>
                                <div class="form-group">
                                    <label for="perempuan_ii">Perempuan</label>
                                    <input type="number" class="form-control" name="perempuan_ii"
                                        oninput="hitungTotal()" placeholder="Masukkan Jumlah Perempuan" required>
                                </div>
                                <div class="thick-hr"></div>
                                <h6>Golongan I</h6>
                                <div class="form-group">
                                    <label for="laki_i">Laki-laki</label>
                                    <input type="number" class="form-control" name="laki_i" oninput="hitungTotal()"
                                        placeholder="Masukkan Jumlah Laki-laki" required>
                                </div>
                                <div class="form-group">
                                    <label for="perempuan_i">Perempuan</label>
                                    <input type="number" class="form-control" name="perempuan_i" oninput="hitungTotal()"
                                        placeholder="Masukkan Jumlah Perempuan" required>
                                </div>
                                <div class="thick-hr"></div>
                                <h6>Jumlah</h6>
                                <div class="form-group">
                                    <label for="laki_jumlah">Laki-laki</label>
                                    <input type="number" class="form-control" name="laki_jumlah" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="perempuan_jumlah">Perempuan</label>
                                    <input type="number" class="form-control" name="perempuan_jumlah" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="total">Total</label>
                                    <input type="number" class="form-control" name="total" readonly>
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
    function hitungTotal() {
        // Read values from input fields
        var laki_iv = parseInt(document.getElementsByName('laki_iv')[0].value) || 0;
        var perempuan_iv = parseInt(document.getElementsByName('perempuan_iv')[0].value) || 0;

        var laki_iii = parseInt(document.getElementsByName('laki_iii')[0].value) || 0;
        var perempuan_iii = parseInt(document.getElementsByName('perempuan_iii')[0].value) || 0;

        var laki_ii = parseInt(document.getElementsByName('laki_ii')[0].value) || 0;
        var perempuan_ii = parseInt(document.getElementsByName('perempuan_ii')[0].value) || 0;

        var laki_i = parseInt(document.getElementsByName('laki_i')[0].value) || 0;
        var perempuan_i = parseInt(document.getElementsByName('perempuan_i')[0].value) || 0;

        // Calculate laki_jumlah and perempuan_jumlah
        var laki_jumlah = laki_iv + laki_iii + laki_ii + laki_i;
        var perempuan_jumlah = perempuan_iv + perempuan_iii + perempuan_ii + perempuan_i;

        // Update the input fields
        document.getElementsByName('laki_jumlah')[0].value = laki_jumlah;
        document.getElementsByName('perempuan_jumlah')[0].value = perempuan_jumlah;
        document.getElementsByName('total')[0].value = laki_jumlah + perempuan_jumlah;
    }
</script>
@endpush