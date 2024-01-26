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
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12" style="margin-left: 12px;">
                            <br>
                            <h3>Semester {{ $semester }}</h3>
                            <h4>Tambah Data Sebaran Pejabat Fungsional Tertentu Menurut Fungsi dan Jenis Kelamin</h4>
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
                            <form action="{{ route('fungsionalsex.store', ['semester' => $semester]) }}" method="POST">
                                @csrf
                                <input type="hidden" name="semester" value="{{ $semester }}">
                                <h6>PEH</h6>
                                <div class="form-group">
                                    <label for="laki_peh">Laki-laki</label>
                                    <input type="number" class="form-control" name="laki_peh" placeholder=""
                                        oninput="hitungTotal()" required>
                                </div>
                                <div class="form-group">
                                    <label for="perempuan_peh">Perempuan</label>
                                    <input type="number" class="form-control" name="perempuan_peh" placeholder=""
                                        oninput="hitungTotal()" required>
                                </div>
                                <div class="thick-hr"></div>
                                <h6>Polhut</h6>
                                <div class="form-group">
                                    <label for="laki_polhut">Laki-laki</label>
                                    <input type="number" class="form-control" name="laki_polhut" placeholder=""
                                        oninput="hitungTotal()" required>
                                </div>
                                <div class="form-group">
                                    <label for="perempuan_polhut">Perempuan</label>
                                    <input type="number" class="form-control" name="perempuan_polhut"
                                        oninput="hitungTotal()" required>
                                </div>
                                <div class="thick-hr"></div>
                                <h6>Penyuluh</h6>
                                <div class="form-group">
                                    <label for="laki_penyuluh">Laki-laki</label>
                                    <input type="number" class="form-control" name="laki_penyuluh"
                                        oninput="hitungTotal()" required>
                                </div>
                                <div class="form-group">
                                    <label for="perempuan_penyuluh">Perempuan</label>
                                    <input type="number" class="form-control" name="perempuan_penyuluh"
                                        oninput="hitungTotal()" required>
                                </div>
                                <div class="thick-hr"></div>
                                <h6>Pranata Komputer</h6>
                                <div class="form-group">
                                    <label for="laki_pranata">Laki-laki</label>
                                    <input type="number" class="form-control" name="laki_pranata"
                                        oninput="hitungTotal()" required>
                                </div>
                                <div class="form-group">
                                    <label for="perempuan_pranata">Perempuan</label>
                                    <input type="number" class="form-control" name="perempuan_pranata"
                                        oninput="hitungTotal()" required>
                                </div>
                                <div class="thick-hr"></div>
                                <h6>Statistisi</h6>
                                <div class="form-group">
                                    <label for="laki_statistisi">Laki-laki</label>
                                    <input type="number" class="form-control" name="laki_statistisi"
                                        oninput="hitungTotal()" required>
                                </div>
                                <div class="form-group">
                                    <label for="perempuan_statistisi">Perempuan</label>
                                    <input type="number" class="form-control" name="perempuan_statistisi"
                                        oninput="hitungTotal()" required>
                                </div>
                                <div class="thick-hr"></div>
                                <h6>Analis Kepegawaian</h6>
                                <div class="form-group">
                                    <label for="laki_analis">Laki-laki</label>
                                    <input type="number" class="form-control" name="laki_analis" oninput="hitungTotal()"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="perempuan_analis">Perempuan</label>
                                    <input type="number" class="form-control" name="perempuan_analis"
                                        oninput="hitungTotal()" required>
                                </div>
                                <div class="thick-hr"></div>
                                <h6>Arsiparis</h6>
                                <div class="form-group">
                                    <label for="laki_arsiparis">Laki-laki</label>
                                    <input type="number" class="form-control" name="laki_arsiparis"
                                        oninput="hitungTotal()" required>
                                </div>
                                <div class="form-group">
                                    <label for="perempuan_arsiparis">Perempuan</label>
                                    <input type="number" class="form-control" name="perempuan_arsiparis"
                                        oninput="hitungTotal()" required>
                                </div>
                                <div class="thick-hr"></div>
                                <h6>Perencana</h6>
                                <div class="form-group">
                                    <label for="laki_perencana">Laki-laki</label>
                                    <input type="number" class="form-control" name="laki_perencana"
                                        oninput="hitungTotal()" required>
                                </div>
                                <div class="form-group">
                                    <label for="perempuan_perencana">Perempuan</label>
                                    <input type="number" class="form-control" name="perempuan_perencana"
                                        oninput="hitungTotal()" required>
                                </div>
                                <div class="thick-hr"></div>
                                <h6>Pengadaan Barjas</h6>
                                <div class="form-group">
                                    <label for="laki_pengadaan">Laki-laki</label>
                                    <input type="number" class="form-control" name="laki_pengadaan"
                                        oninput="hitungTotal()" required>
                                </div>
                                <div class="form-group">
                                    <label for="perempuan_pengadaan">Perempuan</label>
                                    <input type="number" class="form-control" name="perempuan_pengadaan"
                                        oninput="hitungTotal()" required>
                                </div>
                                <div class="thick-hr"></div>
                                <h6>Jumlah</h6>
                                <div class="form-group">
                                    <label for="laki_jumlah">Jumlah Laki-laki</label>
                                    <input type="number" class="form-control" name="laki_jumlah" oninput="hitungTotal()"
                                        readonly>
                                </div>
                                <div class="form-group">
                                    <label for="perempuan_jumlah">Jumlah Perempuan</label>
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
        var lakipeh = parseInt(document.getElementsByName('laki_peh')[0].value) || 0;
        var perempuanpeh = parseInt(document.getElementsByName('perempuan_peh')[0].value) || 0;
        
        var lakipolhut = parseInt(document.getElementsByName('laki_polhut')[0].value) || 0;
        var perempuanpolhut = parseInt(document.getElementsByName('perempuan_polhut')[0].value) || 0;

        var lakipenyuluh = parseInt(document.getElementsByName('laki_penyuluh')[0].value) || 0;
        var perempuanpenyuluh = parseInt(document.getElementsByName('perempuan_penyuluh')[0].value) || 0;

        var lakipranata = parseInt(document.getElementsByName('laki_pranata')[0].value) || 0;
        var perempuanpranata = parseInt(document.getElementsByName('perempuan_pranata')[0].value) || 0;

        var lakistatistisi = parseInt(document.getElementsByName('laki_statistisi')[0].value) || 0;
        var perempuanstatistisi = parseInt(document.getElementsByName('perempuan_statistisi')[0].value) || 0;

        var lakianalis = parseInt(document.getElementsByName('laki_analis')[0].value) || 0;
        var perempuananalis = parseInt(document.getElementsByName('perempuan_analis')[0].value) || 0;

        var lakiarsiparis = parseInt(document.getElementsByName('laki_arsiparis')[0].value) || 0;
        var perempuanarsiparis = parseInt(document.getElementsByName('perempuan_arsiparis')[0].value) || 0;

        var lakiperencana = parseInt(document.getElementsByName('laki_perencana')[0].value) || 0;
        var perempuanperencana = parseInt(document.getElementsByName('perempuan_perencana')[0].value) || 0;

        var lakipengadaan = parseInt(document.getElementsByName('laki_pengadaan')[0].value) || 0;
        var perempuanpengadaan = parseInt(document.getElementsByName('perempuan_pengadaan')[0].value) || 0;

        var laki_jumlah = lakipeh + lakipolhut + lakipenyuluh + lakipranata + lakistatistisi + lakianalis + lakiarsiparis + lakiperencana + lakipengadaan;
        document.getElementsByName('laki_jumlah')[0].value = laki_jumlah;

        var perempuan_jumlah = perempuanpeh + perempuanpolhut + perempuanpenyuluh + perempuanpranata + perempuanstatistisi + perempuananalis + perempuanarsiparis + perempuanperencana + perempuanpengadaan;
        document.getElementsByName('perempuan_jumlah')[0].value = perempuan_jumlah;

        var total = laki_jumlah + perempuan_jumlah;
        document.getElementsByName('total')[0].value = total;
    }
</script>
@endpush