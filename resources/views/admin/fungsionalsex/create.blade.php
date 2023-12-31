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
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
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
                            <form action="{{ route('fungsionalsex.store', ['semester' => $semester]) }}" method="POST">
                                @csrf
                                <input type="hidden" name="semester" value="{{ $semester }}">

                                <h6>PEH</h6>
                                <div class="form-group">
                                    <label for="laki_peh">Laki PEH</label>
                                    <input type="number" class="form-control" name="laki_peh"
                                        placeholder="Masukkan Laki PEH" required>
                                </div>
                                <div class="form-group">
                                    <label for="perempuan_peh">Perempuan PEH</label>
                                    <input type="number" class="form-control" name="perempuan_peh"
                                        placeholder="Masukkan Perempuan PEH" required>
                                </div>
                                <div class="thick-hr"></div>
                                <h6>Polhut</h6>
                                <div class="form-group">
                                    <label for="laki_polhut">Laki Polhut</label>
                                    <input type="number" class="form-control" name="laki_polhut"
                                        placeholder="Masukkan Laki Polhut" required>
                                </div>
                                <div class="form-group">
                                    <label for="perempuan_polhut">Perempuan Polhut</label>
                                    <input type="number" class="form-control" name="perempuan_polhut"
                                        placeholder="Masukkan Perempuan Polhut" required>
                                </div>
                                <div class="thick-hr"></div>
                                <h6>Penyuluh</h6>
                                <div class="form-group">
                                    <label for="laki_penyuluh">Laki Penyuluh</label>
                                    <input type="number" class="form-control" name="laki_penyuluh"
                                        placeholder="Masukkan Laki Penyuluh" required>
                                </div>
                                <div class="form-group">
                                    <label for="perempuan_penyuluh">Perempuan Penyuluh</label>
                                    <input type="number" class="form-control" name="perempuan_penyuluh"
                                        placeholder="Masukkan Perempuan Penyuluh" required>
                                </div>
                                <div class="thick-hr"></div>
                                <h6>Pranata Komputer</h6>
                                <div class="form-group">
                                    <label for="laki_pranata">Laki Pranata Komputer</label>
                                    <input type="number" class="form-control" name="laki_pranata"
                                        placeholder="Masukkan Laki Pranata Komputer" required>
                                </div>
                                <div class="form-group">
                                    <label for="perempuan_pranata">Perempuan Pranata Komputer</label>
                                    <input type="number" class="form-control" name="perempuan_pranata"
                                        placeholder="Masukkan Perempuan Pranata Komputer" required>
                                </div>
                                <div class="thick-hr"></div>
                                <h6>Statistisi</h6>
                                <div class="form-group">
                                    <label for="laki_statistisi">Laki Statistisi</label>
                                    <input type="number" class="form-control" name="laki_statistisi"
                                        placeholder="Masukkan Laki Statistisi" required>
                                </div>
                                <div class="form-group">
                                    <label for="perempuan_statistisi">Perempuan Statistisi</label>
                                    <input type="number" class="form-control" name="perempuan_statistisi"
                                        placeholder="Masukkan Perempuan Statistisi" required>
                                </div>
                                <div class="thick-hr"></div>
                                <h6>Analis Kepegawaian</h6>
                                <div class="form-group">
                                    <label for="laki_analis">Laki Analis Kepegawaian</label>
                                    <input type="number" class="form-control" name="laki_analis"
                                        placeholder="Masukkan Laki Analis Kepegawaian" required>
                                </div>
                                <div class="form-group">
                                    <label for="perempuan_analis">Perempuan Analis Kepegawaian</label>
                                    <input type="number" class="form-control" name="perempuan_analis"
                                        placeholder="Masukkan Perempuan Analis Kepegawaian" required>
                                </div>
                                <div class="thick-hr"></div>
                                <h6>Arsiparis</h6>
                                <div class="form-group">
                                    <label for="laki_arsiparis">Laki Arsiparis</label>
                                    <input type="number" class="form-control" name="laki_arsiparis"
                                        placeholder="Masukkan Laki Arsiparis" required>
                                </div>
                                <div class="form-group">
                                    <label for="perempuan_arsiparis">Perempuan Arsiparis</label>
                                    <input type="number" class="form-control" name="perempuan_arsiparis"
                                        placeholder="Masukkan Perempuan Arsiparis" required>
                                </div>
                                <div class="thick-hr"></div>
                                <h6>Perencana</h6>
                                <div class="form-group">
                                    <label for="laki_perencana">Laki Perencana</label>
                                    <input type="number" class="form-control" name="laki_perencana"
                                        placeholder="Masukkan Laki Perencana" required>
                                </div>
                                <div class="form-group">
                                    <label for="perempuan_perencana">Perempuan Perencana</label>
                                    <input type="number" class="form-control" name="perempuan_perencana"
                                        placeholder="Masukkan Perempuan Perencana" required>
                                </div>
                                <div class="thick-hr"></div>
                                <h6>Pengadaan Barjas</h6>
                                <div class="form-group">
                                    <label for="laki_pengadaan">Laki Pengadaan Barjas</label>
                                    <input type="number" class="form-control" name="laki_pengadaan"
                                        placeholder="Masukkan Laki Pengadaan Barjas" required>
                                </div>
                                <div class="form-group">
                                    <label for="perempuan_pengadaan">Perempuan Pengadaan Barjas</label>
                                    <input type="number" class="form-control" name="perempuan_pengadaan"
                                        placeholder="Masukkan Perempuan Pengadaan Barjas" required>
                                </div>
                                <div class="thick-hr"></div>
                                <h6>Jumlah</h6>
                                <div class="form-group">
                                    <label for="laki_jumlah">Laki Jumlah</label>
                                    <input type="number" class="form-control" name="laki_jumlah"
                                        placeholder="Masukkan Laki Jumlah" required>
                                </div>
                                <div class="form-group">
                                    <label for="perempuan_jumlah">Perempuan Jumlah</label>
                                    <input type="number" class="form-control" name="perempuan_jumlah"
                                        placeholder="Masukkan Perempuan Jumlah" required>
                                </div>
                                <div class="thick-hr"></div>
                                <h6>Total</h6>
                                <div class="form-group">
                                    <label for="total">Total</label>
                                    <input type="number" class="form-control" name="total" placeholder="Masukkan Total"
                                        required>
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