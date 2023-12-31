@extends('layouts.app')

@section('title', 'Tambah Data Sebaran Pejabat Fungsional Tertentu Menurut Fungsi, Tingkat Pendidikan dan Jenis Kelamin'
. $semester)
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
                            <h4>Tambah Data Sebaran Pejabat Fungsional Tertentu Menurut Fungsi, Tingkat Pendidikan dan
                                Jenis Kelamin</h4>
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
                            <form action="{{ route('fungsionalpendidikan.store', ['semester' => $semester]) }}"
                                method="POST">
                                @csrf
                                <input type="hidden" name="semester" value="{{ $semester }}">
                                <div class="form-group">
                                    <label for="jenis_jabatan_fungsional">Jenis Jabatan Fungsional Tertentu
                                    </label>
                                    <input type="text" class="form-control" name="jenis_jabatan_fungsional"
                                        placeholder="Masukkan Perempuan" id="jenis_jabatan_fungsional" required>
                                </div>
                                <div class="thick-hr"></div>
                                <h6>S3</h6>
                                <div class="form-group">
                                    <label for="l_s3">Laki-laki</label>
                                    <input type="number" class="form-control" name="l_s3" id="l_s3"
                                        placeholder="Masukkan Laki-laki" required>
                                </div>
                                <div class="form-group">
                                    <label for="p_s3">Perempuan</label>
                                    <input type="number" class="form-control" name="p_s3"
                                        placeholder="Masukkan Perempuan" id="p_s3" required>
                                </div>
                                <div class="thick-hr"></div>
                                <h6>S2</h6>
                                <div class="form-group">
                                    <label for="l_s2">Laki-laki</label>
                                    <input type="number" class="form-control" name="l_s2" id="l_s2"
                                        placeholder="Masukkan Laki-laki" required>
                                </div>
                                <div class="form-group">
                                    <label for="p_s2">Perempuan</label>
                                    <input type="number" class="form-control" name="p_s2" id="p_s2"
                                        placeholder="Masukkan Perempuan" required>
                                </div>
                                <div class="thick-hr"></div>
                                <h6>S1/D4</h6>
                                <div class="form-group">
                                    <label for="l_s1">Laki-laki</label>
                                    <input type="number" class="form-control" name="l_s1" id="l_s1"
                                        placeholder="Masukkan Laki-laki" required>
                                </div>
                                <div class="form-group">
                                    <label for="p_s1">Perempuan</label>
                                    <input type="number" class="form-control" name="p_s1" id="p_s1"
                                        placeholder="Masukkan Perempuan" required>
                                </div>
                                <div class="thick-hr"></div>
                                <h6>D3</h6>
                                <div class="form-group">
                                    <label for="l_d3">Laki-laki</label>
                                    <input type="number" class="form-control" name="l_d3" id="l_d3"
                                        placeholder="Masukkan Laki-laki" required>
                                </div>
                                <div class="form-group">
                                    <label for="p_d3">Perempuan</label>
                                    <input type="number" class="form-control" name="p_d3" id="p_d3"
                                        placeholder="Masukkan Perempuan" required>
                                </div>
                                <div class="thick-hr"></div>
                                <h6>SLTA</h6>
                                <div class="form-group">
                                    <label for="l_slta">Laki-laki</label>
                                    <input type="number" class="form-control" name="l_slta" id="l_slta"
                                        placeholder="Masukkan Laki-laki" required>
                                </div>
                                <div class="form-group">
                                    <label for="p_slta">Perempuan</label>
                                    <input type="number" class="form-control" name="p_slta" id="p_slta"
                                        placeholder="Masukkan Perempuan" required>
                                </div>
                                <div class="thick-hr"></div>
                                <h6>SLTP</h6>
                                <div class="form-group">
                                    <label for="l_sltp">Laki-laki</label>
                                    <input type="number" class="form-control" name="l_sltp" id="l_sltp"
                                        placeholder="Masukkan Laki-laki" required>
                                </div>
                                <div class="form-group">
                                    <label for="p_sltp">Perempuan</label>
                                    <input type="number" class="form-control" name="p_sltp" id="p_sltp"
                                        placeholder="Masukkan Perempuan" required>
                                </div>
                                <div class="thick-hr"></div>
                                <h6>SD</h6>
                                <div class="form-group">
                                    <label for="l_sd">Laki-laki</label>
                                    <input type="number" class="form-control" name="l_sd" id="l_sd"
                                        placeholder="Masukkan Laki-laki" required>
                                </div>
                                <div class="form-group">
                                    <label for="p_sd">Perempuan</label>
                                    <input type="number" class="form-control" name="p_sd" id="p_sd"
                                        placeholder="Masukkan Perempuan" required>
                                </div>
                                <div class="thick-hr"></div>
                                <h6>Jumlah</h6>
                                <div class="form-group">
                                    <label for="l_jumlah">Laki-laki</label>
                                    <input type="number" class="form-control" name="l_jumlah"
                                        placeholder="Jumlah Laki-laki" id="l_jumlah" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="p_jumlah">Perempuan</label>
                                    <input type="number" class="form-control" name="p_jumlah"
                                        placeholder="Jumlah Perempuan" id="p_jumlah" readonly>
                                </div>
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
    function hitungJumlah() {
        const tingkatan = ['s3', 's2', 's1', 'd3', 'slta', 'sltp', 'sd']; // Array nama tingkatan
        let totalL = 0;
        let totalP = 0;

        tingkatan.forEach(tingkat => {
            const laki = parseInt(document.getElementById(`l_${tingkat}`).value) || 0;
            const perempuan = parseInt(document.getElementById(`p_${tingkat}`).value) || 0;
            totalL += laki;
            totalP += perempuan;
        });

        document.getElementById('l_jumlah').value = totalL;
        document.getElementById('p_jumlah').value = totalP;
        document.getElementById('total').value = totalL + totalP;
    }

    document.querySelectorAll('input[type=number]').forEach(input => {
        input.addEventListener('change', hitungJumlah);
    });

    hitungJumlah();
</script>
@endpush