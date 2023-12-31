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
                                    <label for="peh">Jenjang Jabatan</label>
                                    <input type="number" class="form-control" name="peh"
                                        placeholder="Masukkan Jenjang Jabatan" required>
                                </div>
                                <div class="form-group">
                                    <label for="jumlah_peh">Jumlah (Orang)</label>
                                    <input type="number" class="form-control" name="jumlah_peh"
                                        placeholder="Masukkan Jumlah (Orang)" id="jumlah_peh" required>
                                </div>
                                <div class="thick-hr"></div>
                                <h6>Polhut</h6>
                                <div class="form-group">
                                    <label for="polhut">Jenjang Jabatan</label>
                                    <input type="number" class="form-control" name="polhut"
                                        placeholder="Masukkan Jenjang Jabatan" required>
                                </div>
                                <div class="form-group">
                                    <label for="jumlah_polhut">Jumlah (Orang)</label>
                                    <input type="number" class="form-control" name="jumlah_polhut" id="jumlah_polhut"
                                        placeholder="Masukkan Jumlah (Orang)" required>
                                </div>
                                <div class="thick-hr"></div>
                                <h6>Penyuluh</h6>
                                <div class="form-group">
                                    <label for="penyuluh">Jenjang Jabatan</label>
                                    <input type="number" class="form-control" name="penyuluh"
                                        placeholder="Masukkan Jenjang Jabatan" required>
                                </div>
                                <div class="form-group">
                                    <label for="jumlah_penyuluh">Jumlah (Orang)</label>
                                    <input type="number" class="form-control" name="jumlah_penyuluh"
                                        id="jumlah_penyuluh" placeholder="Masukkan Jumlah (Orang)" required>
                                </div>
                                <div class="thick-hr"></div>
                                <h6>Pranata Komputer</h6>
                                <div class="form-group">
                                    <label for="pranata">Jenjang Jabatan</label>
                                    <input type="number" class="form-control" name="pranata"
                                        placeholder="Masukkan Jenjang Jabatan" required>
                                </div>
                                <div class="form-group">
                                    <label for="jumlah_pranata">Jumlah (Orang)</label>
                                    <input type="number" class="form-control" name="jumlah_pranata" id="jumlah_pranata"
                                        placeholder="Masukkan Jumlah (Orang)" required>
                                </div>
                                <div class="thick-hr"></div>
                                <h6>Statistisi</h6>
                                <div class="form-group">
                                    <label for="statis">Jenjang Jabatan</label>
                                    <input type="number" class="form-control" name="statis"
                                        placeholder="Masukkan Jenjang Jabatan" required>
                                </div>
                                <div class="form-group">
                                    <label for="jumlah_statis">Jumlah (Orang)</label>
                                    <input type="number" class="form-control" name="jumlah_statis" id="jumlah_statis"
                                        placeholder="Masukkan Jumlah (Orang)" required>
                                </div>
                                <div class="thick-hr"></div>
                                <h6>Analis Kepegawaian</h6>
                                <div class="form-group">
                                    <label for="analisis">Jenjang Jabatan</label>
                                    <input type="number" class="form-control" name="analisis"
                                        placeholder="Masukkan Jenjang Jabatan" required>
                                </div>
                                <div class="form-group">
                                    <label for="jumlah_analisis">Jumlah (Orang)</label>
                                    <input type="number" class="form-control" name="jumlah_analisis" id="jumlah_analis"
                                        placeholder="Masukkan Jumlah (Orang)" required>
                                </div>
                                <div class="thick-hr"></div>
                                <h6>Arsiparis</h6>
                                <div class="form-group">
                                    <label for="arsiparis">Jenjang Jabatan</label>
                                    <input type="number" class="form-control" name="arsiparis"
                                        placeholder="Masukkan Jenjang Jabatan" required>
                                </div>
                                <div class="form-group">
                                    <label for="jumlah_arsiparis">Jumlah (Orang)</label>
                                    <input type="number" class="form-control" name="jumlah_arsiparis"
                                        id="jumlah_arsiparis" placeholder="Masukkan Jumlah (Orang)" required>
                                </div>
                                <div class="thick-hr"></div>
                                <h6>Perencana</h6>
                                <div class="form-group">
                                    <label for="perencanana">Jenjang Jabatan</label>
                                    <input type="number" class="form-control" name="perencanana"
                                        placeholder="Masukkan Jenjang Jabatan" required>
                                </div>
                                <div class="form-group">
                                    <label for="jumlah_perencanana">Jumlah (Orang)</label>
                                    <input type="number" class="form-control" name="jumlah_perencanana"
                                        id="jumlah_perencanana" placeholder="Masukkan Jumlah (Orang)" required>
                                </div>
                                <div class="thick-hr"></div>
                                <h6>Pengadaan Barjas</h6>
                                <div class="form-group">
                                    <label for="pengadaan">Jenjang Jabatan</label>
                                    <input type="number" class="form-control" name="pengadaan"
                                        placeholder="Masukkan Jenjang Jabatan" required>
                                </div>
                                <div class="form-group">
                                    <label for="jumlah_pengadaan">Jumlah (Orang)</label>
                                    <input type="number" class="form-control" name="jumlah_pengadaan"
                                        id="jumlah_pengadaan" placeholder="Masukkan Jumlah (Orang)" required>
                                </div>
                                <div class="thick-hr"></div>
                                <div class="form-group">
                                    <label for="total">Total</label>
                                    <input type="number" class="form-control" name="total" placeholder="Total"
                                        id="total" readonly>
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
    // Dapatkan semua input jumlah orang
    const inputs = document.querySelectorAll('input[name^="jumlah_"]');
    const totalInput = document.querySelector('input[name="total"]');

    // Fungsi untuk menghitung total
    function calculateTotal() {
        let total = 0;
        inputs.forEach(input => {
            total += parseInt(input.value) || 0;
        });
        // Masukkan nilai total ke input "Total"
        totalInput.value = total;
    }

    // Tambahkan event listener untuk setiap input jumlah orang
    inputs.forEach(input => {
        input.addEventListener('input', calculateTotal);
    });
</script>
@endpush