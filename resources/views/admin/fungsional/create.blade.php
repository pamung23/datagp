@extends('layouts.app')

@section('title', 'Tambah Data Sebaran Pejabat Fungsional Tertentu Menurut Fungsi dan Jenjang Jabatan' . $semester)
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
                            <h4>Tambah Data Sebaran Pejabat Fungsional Tertentu Menurut Fungsi dan Jenjang Jabatan</h4>
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
                            <form action="{{ route('fungsional.store', ['semester' => $semester]) }}" method="POST">
                                @csrf
                                <input type="hidden" name="semester" value="{{ $semester }}">
                                <h6>PEH</h6>
                                <div class="form-group">
                                    <label for="calon_terampil_peh">Calon Terampil</label>
                                    <input type="number" class="form-control" name="calon_terampil_peh" placeholder=""
                                        oninput="hitungTotal()" required>
                                </div>
                                <div class="form-group">
                                    <label for="terampil_peh">Terampil</label>
                                    <input type="number" class="form-control" name="terampil_peh" placeholder=""
                                        oninput="hitungTotal()" required>
                                </div>
                                <div class="form-group">
                                    <label for="calon_ahli_peh">Calon Ahli</label>
                                    <input type="number" class="form-control" name="calon_ahli_peh" placeholder=""
                                        oninput="hitungTotal()" required>
                                </div>
                                <div class="form-group">
                                    <label for="ahli_peh">Ahli</label>
                                    <input type="number" class="form-control" name="ahli_peh" placeholder=""
                                        oninput="hitungTotal()" required>
                                </div>
                                <div class="form-group">
                                    <label for="jumlah_peh">Jumlah (Orang)</label>
                                    <input type="number" class="form-control" name="jumlah_peh" placeholder=""
                                        oninput="hitungTotal()" readonly>
                                </div>
                                <div class="thick-hr"></div>
                                <h6>Polhut</h6>
                                <div class="form-group">
                                    <label for="calon_terampil_polhut">Calon Terampil</label>
                                    <input type="number" class="form-control" name="calon_terampil_polhut"
                                        placeholder="" oninput="hitungTotal()" required>
                                </div>
                                <div class="form-group">
                                    <label for="terampil_polhut">Terampil</label>
                                    <input type="number" class="form-control" name="terampil_polhut" placeholder=""
                                        oninput="hitungTotal()" required>
                                </div>
                                <div class="form-group">
                                    <label for="calon_ahli_polhut">Calon Ahli</label>
                                    <input type="number" class="form-control" name="calon_ahli_polhut" placeholder=""
                                        oninput="hitungTotal()" required>
                                </div>
                                <div class="form-group">
                                    <label for="ahli_polhut">Ahli</label>
                                    <input type="number" class="form-control" name="ahli_polhut" placeholder=""
                                        oninput="hitungTotal()" required>
                                </div>
                                <div class="form-group">
                                    <label for="jumlah_polhut">Jumlah (Orang)</label>
                                    <input type="number" class="form-control" name="jumlah_polhut" id="jumlah_polhut"
                                        placeholder="" oninput="hitungTotal()" readonly>
                                </div>
                                <div class="thick-hr"></div>
                                <h6>Penyuluh</h6>
                                <div class="form-group">
                                    <label for="calon_terampil_penyuluh">Calon Terampil</label>
                                    <input type="number" class="form-control" name="calon_terampil_penyuluh"
                                        placeholder="" oninput="hitungTotal()" required>
                                </div>
                                <div class="form-group">
                                    <label for="terampil_penyuluh">Terampil</label>
                                    <input type="number" class="form-control" name="terampil_penyuluh" placeholder=""
                                        oninput="hitungTotal()" required>
                                </div>
                                <div class="form-group">
                                    <label for="calon_ahli_penyuluh">Calon Ahli</label>
                                    <input type="number" class="form-control" name="calon_ahli_penyuluh" placeholder=""
                                        oninput="hitungTotal()" required>
                                </div>
                                <div class="form-group">
                                    <label for="ahli_penyuluh">Ahli</label>
                                    <input type="number" class="form-control" name="ahli_penyuluh" placeholder=""
                                        oninput="hitungTotal()" required>
                                </div>
                                <div class="form-group">
                                    <label for="jumlah_penyuluh">Jumlah (Orang)</label>
                                    <input type="number" class="form-control" name="jumlah_penyuluh"
                                        id="jumlah_penyuluh" placeholder="" oninput="hitungTotal()" readonly>
                                </div>
                                <div class="thick-hr"></div>
                                <h6>Pranata Komputer</h6>
                                <div class="form-group">
                                    <label for="calon_terampil_pranata">Calon Terampil</label>
                                    <input type="number" class="form-control" name="calon_terampil_pranata"
                                        placeholder="" oninput="hitungTotal()" required>
                                </div>
                                <div class="form-group">
                                    <label for="terampil_pranata">Terampil</label>
                                    <input type="number" class="form-control" name="terampil_pranata" placeholder=""
                                        oninput="hitungTotal()" required>
                                </div>
                                <div class="form-group">
                                    <label for="calon_ahli_pranata">Calon Ahli</label>
                                    <input type="number" class="form-control" name="calon_ahli_pranata" placeholder=""
                                        oninput="hitungTotal()" required>
                                </div>
                                <div class="form-group">
                                    <label for="ahli_pranata">Ahli</label>
                                    <input type="number" class="form-control" name="ahli_pranata" placeholder=""
                                        oninput="hitungTotal()" required>
                                </div>
                                <div class="form-group">
                                    <label for="jumlah_pranata">Jumlah (Orang)</label>
                                    <input type="number" class="form-control" name="jumlah_pranata" id="jumlah_pranata"
                                        placeholder="" oninput="hitungTotal()" readonly>
                                </div>
                                <div class="thick-hr"></div>
                                <h6>Statistisi</h6>
                                <div class="form-group">
                                    <label for="calon_terampil_statis">Calon Terampil</label>
                                    <input type="number" class="form-control" name="calon_terampil_statis"
                                        placeholder="" oninput="hitungTotal()" required>
                                </div>
                                <div class="form-group">
                                    <label for="terampil_statis">Terampil</label>
                                    <input type="number" class="form-control" name="terampil_statis" placeholder=""
                                        oninput="hitungTotal()" required>
                                </div>
                                <div class="form-group">
                                    <label for="calon_ahli_statis">Calon Ahli</label>
                                    <input type="number" class="form-control" name="calon_ahli_statis" placeholder=""
                                        oninput="hitungTotal()" required>
                                </div>
                                <div class="form-group">
                                    <label for="ahli_statis">Ahli</label>
                                    <input type="number" class="form-control" name="ahli_statis" placeholder=""
                                        oninput="hitungTotal()" required>
                                </div>
                                <div class="form-group">
                                    <label for="jumlah_statis">Jumlah (Orang)</label>
                                    <input type="number" class="form-control" name="jumlah_statis" id="jumlah_statis"
                                        placeholder="" oninput="hitungTotal()" readonly>
                                </div>
                                <div class="thick-hr"></div>
                                <h6>Analis Kepegawaian</h6>
                                <div class="form-group">
                                    <label for="calon_terampil_analisis">Calon Terampil</label>
                                    <input type="number" class="form-control" name="calon_terampil_analisis"
                                        placeholder="" oninput="hitungTotal()" required>
                                </div>
                                <div class="form-group">
                                    <label for="terampil_analisis">Terampil</label>
                                    <input type="number" class="form-control" name="terampil_analisis" placeholder=""
                                        oninput="hitungTotal()" required>
                                </div>
                                <div class="form-group">
                                    <label for="calon_ahli_analisis">Calon Ahli</label>
                                    <input type="number" class="form-control" name="calon_ahli_analisis" placeholder=""
                                        oninput="hitungTotal()" required>
                                </div>
                                <div class="form-group">
                                    <label for="ahli_analisis">Ahli</label>
                                    <input type="number" class="form-control" name="ahli_analisis" placeholder=""
                                        oninput="hitungTotal()" required>
                                </div>
                                <div class="form-group">
                                    <label for="jumlah_analisis">Jumlah (Orang)</label>
                                    <input type="number" class="form-control" name="jumlah_analisis" id="jumlah_analis"
                                        placeholder="" oninput="hitungTotal()" readonly>
                                </div>
                                <div class="thick-hr"></div>
                                <h6>Arsiparis</h6>
                                <div class="form-group">
                                    <label for="calon_terampil_arsiparis">Calon Terampil</label>
                                    <input type="number" class="form-control" name="calon_terampil_arsiparis"
                                        placeholder="" oninput="hitungTotal()" required>
                                </div>
                                <div class="form-group">
                                    <label for="terampil_arsiparis">Terampil</label>
                                    <input type="number" class="form-control" name="terampil_arsiparis" placeholder=""
                                        oninput="hitungTotal()" required>
                                </div>
                                <div class="form-group">
                                    <label for="calon_ahli_arsiparis">Calon Ahli</label>
                                    <input type="number" class="form-control" name="calon_ahli_arsiparis" placeholder=""
                                        oninput="hitungTotal()" required>
                                </div>
                                <div class="form-group">
                                    <label for="ahli_arsiparis">Ahli</label>
                                    <input type="number" class="form-control" name="ahli_arsiparis" placeholder=""
                                        oninput="hitungTotal()" required>
                                </div>
                                <div class="form-group">
                                    <label for="jumlah_arsiparis">Jumlah (Orang)</label>
                                    <input type="number" class="form-control" name="jumlah_arsiparis"
                                        id="jumlah_arsiparis" placeholder="" oninput="hitungTotal()" readonly>
                                </div>
                                <div class="thick-hr"></div>
                                <h6>Perencana</h6>
                                <div class="form-group">
                                    <label for="calon_terampil_perencana">Calon Terampil</label>
                                    <input type="number" class="form-control" name="calon_terampil_perencana"
                                        placeholder="" oninput="hitungTotal()" required>
                                </div>
                                <div class="form-group">
                                    <label for="terampil_perencana">Terampil</label>
                                    <input type="number" class="form-control" name="terampil_perencana" placeholder=""
                                        oninput="hitungTotal()" required>
                                </div>
                                <div class="form-group">
                                    <label for="calon_ahli_perencana">Calon Ahli</label>
                                    <input type="number" class="form-control" name="calon_ahli_perencana" placeholder=""
                                        oninput="hitungTotal()" required>
                                </div>
                                <div class="form-group">
                                    <label for="ahli_perencana">Ahli</label>
                                    <input type="number" class="form-control" name="ahli_perencana" placeholder=""
                                        oninput="hitungTotal()" required>
                                </div>
                                <div class="form-group">
                                    <label for="jumlah_perencana">Jumlah (Orang)</label>
                                    <input type="number" class="form-control" name="jumlah_perencana"
                                        id="jumlah_perencanana" placeholder="" oninput="hitungTotal()" readonly>
                                </div>
                                <div class="thick-hr"></div>
                                <h6>Pengadaan Barjas</h6>
                                <div class="form-group">
                                    <label for="calon_terampil_pengadaan">Calon Terampil</label>
                                    <input type="number" class="form-control" name="calon_terampil_pengadaan"
                                        placeholder="" oninput="hitungTotal()" required>
                                </div>
                                <div class="form-group">
                                    <label for="terampil_pengadaan">Terampil</label>
                                    <input type="number" class="form-control" name="terampil_pengadaan" placeholder=""
                                        oninput="hitungTotal()" required>
                                </div>
                                <div class="form-group">
                                    <label for="calon_ahli_pengadaan">Calon Ahli</label>
                                    <input type="number" class="form-control" name="calon_ahli_pengadaan" placeholder=""
                                        oninput="hitungTotal()" required>
                                </div>
                                <div class="form-group">
                                    <label for="ahli_pengadaan">Ahli</label>
                                    <input type="number" class="form-control" name="ahli_pengadaan" placeholder=""
                                        oninput="hitungTotal()" required>
                                </div>
                                <div class="form-group">
                                    <label for="jumlah_pengadaan">Jumlah (Orang)</label>
                                    <input type="number" class="form-control" name="jumlah_pengadaan"
                                        id="jumlah_pengadaan" placeholder="" oninput="hitungTotal()" readonly>
                                </div>
                                <div class="thick-hr"></div>
                                <div class="form-group">
                                    <label for="total">Total</label>
                                    <input type="number" class="form-control" name="total" placeholder="Total"
                                        id="total" oninput="hitungTotal()" readonly>
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
        // Hitung total untuk PEH
        var calonTerampilPeh = parseInt(document.getElementsByName('calon_terampil_peh')[0].value) || 0;
        var terampilPeh = parseInt(document.getElementsByName('terampil_peh')[0].value) || 0;
        var calonAhliPeh = parseInt(document.getElementsByName('calon_ahli_peh')[0].value) || 0;
        var ahliPeh = parseInt(document.getElementsByName('ahli_peh')[0].value) || 0;
        var jumlahPeh = calonTerampilPeh + terampilPeh + calonAhliPeh + ahliPeh;
        document.getElementsByName('jumlah_peh')[0].value = jumlahPeh;

        // Hitung total untuk Polhut
        var calonTerampilPolhut = parseInt(document.getElementsByName('calon_terampil_polhut')[0].value) || 0;
        var terampilPolhut = parseInt(document.getElementsByName('terampil_polhut')[0].value) || 0;
        var calonAhliPolhut = parseInt(document.getElementsByName('calon_ahli_polhut')[0].value) || 0;
        var ahliPolhut = parseInt(document.getElementsByName('ahli_polhut')[0].value) || 0;
        var jumlahPolhut = calonTerampilPolhut + terampilPolhut + calonAhliPolhut + ahliPolhut;
        document.getElementsByName('jumlah_polhut')[0].value = jumlahPolhut;

        // Hitung total untuk Penyuluh
        var calonTerampilPenyuluh = parseInt(document.getElementsByName('calon_terampil_penyuluh')[0].value) || 0;
        var terampilPenyuluh = parseInt(document.getElementsByName('terampil_penyuluh')[0].value) || 0;
        var calonAhliPenyuluh = parseInt(document.getElementsByName('calon_ahli_penyuluh')[0].value) || 0;
        var ahliPenyuluh = parseInt(document.getElementsByName('ahli_penyuluh')[0].value) || 0;
        var jumlahPenyuluh = calonTerampilPenyuluh + terampilPenyuluh + calonAhliPenyuluh + ahliPenyuluh;
        document.getElementsByName('jumlah_penyuluh')[0].value = jumlahPenyuluh;

         // Hitung total untuk Pranata
        var calonTerampilpranata = parseInt(document.getElementsByName('calon_terampil_pranata')[0].value) || 0;
        var terampilpranata = parseInt(document.getElementsByName('terampil_pranata')[0].value) || 0;
        var calonAhlipranata = parseInt(document.getElementsByName('calon_ahli_pranata')[0].value) || 0;
        var ahlipranata = parseInt(document.getElementsByName('ahli_pranata')[0].value) || 0;
        var jumlahpranata = calonTerampilpranata + terampilpranata + calonAhlipranata + ahlipranata;
        document.getElementsByName('jumlah_pranata')[0].value = jumlahpranata;

         // Hitung total untuk Statistisi
        var calonTerampilstatis = parseInt(document.getElementsByName('calon_terampil_statis')[0].value) || 0;
        var terampilstatis = parseInt(document.getElementsByName('terampil_statis')[0].value) || 0;
        var calonAhlistatis = parseInt(document.getElementsByName('calon_ahli_statis')[0].value) || 0;
        var ahlistatis = parseInt(document.getElementsByName('ahli_statis')[0].value) || 0;
        var jumlahstatis = calonTerampilstatis + terampilstatis + calonAhlistatis + ahlistatis;
        document.getElementsByName('jumlah_statis')[0].value = jumlahstatis;

         // Hitung total untuk Analisis
         var calonTerampilanalis = parseInt(document.getElementsByName('calon_terampil_analisis')[0].value) || 0;
        var terampilanalis = parseInt(document.getElementsByName('terampil_analisis')[0].value) || 0;
        var calonAhlianalis = parseInt(document.getElementsByName('calon_ahli_analisis')[0].value) || 0;
        var ahlianalis = parseInt(document.getElementsByName('ahli_analisis')[0].value) || 0;
        var jumlahanalis = calonTerampilanalis + terampilanalis + calonAhlianalis + ahlianalis;
        document.getElementsByName('jumlah_analisis')[0].value = jumlahanalis;

         // Hitung total untuk Arsiparis
        var calonTerampilarsiparis = parseInt(document.getElementsByName('calon_terampil_arsiparis')[0].value) || 0;
        var terampilarsiparis = parseInt(document.getElementsByName('terampil_arsiparis')[0].value) || 0;
        var calonAhliarsiparis = parseInt(document.getElementsByName('calon_ahli_arsiparis')[0].value) || 0;
        var ahliarsiparis = parseInt(document.getElementsByName('ahli_arsiparis')[0].value) || 0;
        var jumlaharsiparis = calonTerampilarsiparis + terampilarsiparis + calonAhliarsiparis + ahliarsiparis;
        document.getElementsByName('jumlah_arsiparis')[0].value = jumlaharsiparis;

         // Hitung total untuk Perencana
        var calonTerampilperencana = parseInt(document.getElementsByName('calon_terampil_perencana')[0].value) || 0;
        var terampilperencana = parseInt(document.getElementsByName('terampil_perencana')[0].value) || 0;
        var calonAhliperencana = parseInt(document.getElementsByName('calon_ahli_perencana')[0].value) || 0;
        var ahliperencana = parseInt(document.getElementsByName('ahli_perencana')[0].value) || 0;
        var jumlahperencana = calonTerampilperencana + terampilperencana + calonAhliperencana + ahliperencana;
        document.getElementsByName('jumlah_perencana')[0].value = jumlahperencana;

        // Hitung total untuk Pengadaanbarjas
        var calonTerampilpengadaan = parseInt(document.getElementsByName('calon_terampil_pengadaan')[0].value) || 0;
        var terampilpengadaan = parseInt(document.getElementsByName('terampil_pengadaan')[0].value) || 0;
        var calonAhlipengadaan = parseInt(document.getElementsByName('calon_ahli_pengadaan')[0].value) || 0;
        var ahlipengadaan = parseInt(document.getElementsByName('ahli_pengadaan')[0].value) || 0;
        var jumlahpengadaan = calonTerampilpengadaan + terampilpengadaan + calonAhlipengadaan + ahlipengadaan;
        document.getElementsByName('jumlah_pengadaan')[0].value = jumlahpengadaan;

        // Hitung total keseluruhan
        var total = jumlahPeh + jumlahPolhut + jumlahPenyuluh + jumlahpranata + jumlahstatis + jumlahanalis + jumlaharsiparis + jumlahperencana +jumlahpengadaan;
        document.getElementsByName('total')[0].value = total;
    }
</script>
@endpush