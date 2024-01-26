@extends('layouts.app')

@section('title', 'Tambah Data Sebaran PNS/CPNS Menurut Tingkat Pendidikan dan Jenis Kelamin ' . $semester)

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
                            <h4>Tambah Data Sebaran PNS/CPNS Menurut Tingkat Pendidikan dan Jenis Kelamin</h4>
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
                            <form action="{{ route('pegawaipendidikan.store', ['semester' => $semester]) }}"
                                method="POST">
                                @csrf
                                <input type="hidden" name="semester" value="{{ $semester }}">

                                <h6>Doktor</h6>
                                <div class="form-group">
                                    <label for="laki_doktor">Laki-laki</label>
                                    <input type="number" class="form-control" name="laki_doktor"
                                        placeholder="Masukkan Laki-laki" required oninput="hitungTotal()">
                                </div>
                                <div class="form-group">
                                    <label for="perempuan_doktor">Perempuan</label>
                                    <input type="number" class="form-control" name="perempuan_doktor"
                                        placeholder="Masukkan Perempuan" required oninput="hitungTotal()">
                                </div>
                                <div class="thick-hr"></div>
                                <h6>Master</h6>
                                <div class="form-group">
                                    <label for="laki_master">Laki-laki</label>
                                    <input type="number" class="form-control" name="laki_master"
                                        placeholder="Masukkan Laki-laki" required oninput="hitungTotal()">
                                </div>
                                <div class="form-group">
                                    <label for="perempuan_master">Perempuan</label>
                                    <input type="number" class="form-control" name="perempuan_master"
                                        placeholder="Masukkan Perempuan" required oninput="hitungTotal()">
                                </div>
                                <div class="thick-hr"></div>
                                <h6>Sarjana</h6>
                                <div class="form-group">
                                    <label for="laki_sarjana">Laki-laki</label>
                                    <input type="number" class="form-control" name="laki_sarjana"
                                        placeholder="Masukkan Laki-laki" required oninput="hitungTotal()">
                                </div>
                                <div class="form-group">
                                    <label for="perempuan_sarjana">Perempuan</label>
                                    <input type="number" class="form-control" name="perempuan_sarjana"
                                        placeholder="Masukkan Perempuan" required oninput="hitungTotal()">
                                </div>
                                <div class="thick-hr"></div>
                                <h6>Sarjana Muda</h6>
                                <div class="form-group">
                                    <label for="laki_sarjana_muda">Laki-laki</label>
                                    <input type="number" class="form-control" name="laki_sarjana_muda"
                                        placeholder="Masukkan Laki-laki" required oninput="hitungTotal()">
                                </div>
                                <div class="form-group">
                                    <label for="perempuan_sarjana_muda">Perempuan</label>
                                    <input type="number" class="form-control" name="perempuan_sarjana_muda"
                                        placeholder="Masukkan Perempuan" required oninput="hitungTotal()">
                                </div>
                                <div class="thick-hr"></div>
                                <h6>SLTA</h6>
                                <div class="form-group">
                                    <label for="laki_slta">Laki-laki</label>
                                    <input type="number" class="form-control" name="laki_slta"
                                        placeholder="Masukkan Laki-laki" required oninput="hitungTotal()">
                                </div>
                                <div class="form-group">
                                    <label for="perempuan_SLTA">Perempuan</label>
                                    <input type="number" class="form-control" name="perempuan_slta"
                                        placeholder="Masukkan Perempuan" required oninput="hitungTotal()">
                                </div>
                                <div class="thick-hr"></div>
                                <h6>SLTP</h6>
                                <div class="form-group">
                                    <label for="laki_sltp">Laki-laki</label>
                                    <input type="number" class="form-control" name="laki_sltp"
                                        placeholder="Masukkan Laki-laki" required oninput="hitungTotal()">
                                </div>
                                <div class="form-group">
                                    <label for="perempuan_sltp">Perempuan</label>
                                    <input type="number" class="form-control" name="perempuan_sltp"
                                        placeholder="Masukkan Perempuan" required oninput="hitungTotal()">
                                </div>
                                <div class="thick-hr"></div>
                                <h6>SD</h6>
                                <div class="form-group">
                                    <label for="laki_sd">Laki-laki</label>
                                    <input type="number" class="form-control" name="laki_sd"
                                        placeholder="Masukkan Laki-laki" required oninput="hitungTotal()">
                                </div>
                                <div class="form-group">
                                    <label for="perempuan_sd">Perempuan</label>
                                    <input type="number" class="form-control" name="perempuan_sd"
                                        placeholder="Masukkan Perempuan" required oninput="hitungTotal()">
                                </div>
                                <div class="thick-hr"></div>
                                <h6>Jumlah</h6>
                                <div class="form-group">
                                    <label for="laki_jumlah">Laki-Laki</label>
                                    <input type="number" class="form-control" name="laki_jumlah" oninput="hitungTotal()"
                                        readonly>
                                </div>
                                <div class="form-group">
                                    <label for="perempuan_jumlah">Perempuan</label>
                                    <input type="number" class="form-control" name="perempuan_jumlah"
                                        oninput="hitungTotal()" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="total">Total</label>
                                    <input type="number" class="form-control" name="total" oninput="hitungTotal()"
                                        readonly>
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
                                        // Get the values of each education level for both Laki-Laki and Perempuan
                                        var lakiDoktor = parseInt(document.getElementsByName('laki_doktor')[0].value) || 0;
                                        var perempuanDoktor = parseInt(document.getElementsByName('perempuan_doktor')[0].value) || 0;

                                        var lakiMaster = parseInt(document.getElementsByName('laki_master')[0].value) || 0;
                                        var perempuanMaster = parseInt(document.getElementsByName('perempuan_master')[0].value) || 0;

                                        var lakiSarjana = parseInt(document.getElementsByName('laki_sarjana')[0].value) || 0;
                                        var perempuanSarjana = parseInt(document.getElementsByName('perempuan_sarjana')[0].value) || 0;

                                        var lakiSarjanaMuda = parseInt(document.getElementsByName('laki_sarjana_muda')[0].value) || 0;
                                        var perempuanSarjanaMuda = parseInt(document.getElementsByName('perempuan_sarjana_muda')[0].value) || 0;

                                        var lakislta = parseInt(document.getElementsByName('laki_slta')[0].value) || 0;
                                        var perempuanslta = parseInt(document.getElementsByName('perempuan_slta')[0].value) || 0;

                                        var lakiSltp = parseInt(document.getElementsByName('laki_sltp')[0].value) || 0;
                                        var perempuanSltp = parseInt(document.getElementsByName('perempuan_sltp')[0].value) || 0;
                                       
                                        var lakiSd= parseInt(document.getElementsByName('laki_sd')[0].value) || 0;
                                        var perempuanSd = parseInt(document.getElementsByName('perempuan_sd')[0].value) || 0;

                                        // Calculate Laki Jumlah and Perempuan Jumlah
                                        var lakiJumlah = lakiDoktor + lakiMaster + lakiSarjana + lakiSarjanaMuda + lakislta + lakiSltp + lakiSd ;
                                        var perempuanJumlah = perempuanDoktor + perempuanMaster + perempuanSarjana + perempuanSarjanaMuda + perempuanslta + perempuanSltp + perempuanSd ;

                                        // Update the "Laki Jumlah" and "Perempuan Jumlah" fields
                                        document.getElementsByName('laki_jumlah')[0].value = lakiJumlah;
                                        document.getElementsByName('perempuan_jumlah')[0].value = perempuanJumlah;

                                        // Calculate the total
                                        var total = lakiJumlah + perempuanJumlah;

                                        // Update the "Total" field
                                        document.getElementsByName('total')[0].value = total;
                                    }
</script>
@endpush