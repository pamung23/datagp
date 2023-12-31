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
                            <h4>Tambah Data Perencanaan Pengelolaan Kawasan Konservasi</h4>
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
                            <form action="{{ route('perencanaanpkk.store', ['semester' => $semester]) }}" method="POST">
                                @csrf
                                <input type="hidden" name="semester" value="{{ $semester }}">
                                <h6>Rencana Pengelolaan Jangka Panjang</h6>
                                <div class="form-group">
                                    <label for="jpan_nomor">Nomor Jangka Panjang</label>
                                    <input type="text" class="form-control" name="jpan_nomor"
                                        placeholder="Masukkan Nomor Jangka Panjang" required>
                                </div>
                                <div class="form-group">
                                    <label for="jpan_tanggal">Tanggal Jangka Panjang</label>
                                    <input id="basicFlatpickr" class="form-control flatpickr flatpickr-input "
                                        type="text" placeholder="Pilih Tanggal.." id="jpan_tanggal" name="jpan_tanggal"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="jpan_mulai">Mulai Jangka Panjang</label>
                                    <input id="basicFlatpickr2" class="form-control flatpickr flatpickr-input "
                                        type="text" placeholder="Pilih Tanggal.." id="jpan_mulai" name="jpan_mulai"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="jpan_akhir">Akhir Jangka Panjang</label>
                                    <input id="basicFlatpickr3" class="form-control flatpickr flatpickr-input "
                                        type="text" placeholder="Pilih Tanggal.." id="jpan_akhir" name="jpan_akhir"
                                        required>
                                </div>
                                <div class="thick-hr"></div>
                                <h6>Rencana Pengelolaan Jangka Pendek</h6>
                                <div class="form-group">
                                    <label for="jpen_nomor">Nomor Jangka Pendek</label>
                                    <input type="text" class="form-control" name="jpen_nomor"
                                        placeholder="Masukkan Nomor Jangka Pendek" required>
                                </div>
                                <div class="form-group">
                                    <label for="jpen_tanggal">Tanggal Jangka Pendek</label>
                                    <input id="basicFlatpickr4" class="form-control flatpickr flatpickr-input "
                                        type="text" placeholder="Pilih Tanggal.." id="jpen_tanggal" name="jpen_tanggal"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="jpen_periode">Periode Jangka Pendek</label>
                                    <select class="form-control" name="jpen_periode" required>
                                        <option value="1 Tahun">1 Tahun</option>
                                        <option value="2 Tahun">2 Tahun</option>
                                        <option value="3 Tahun">3 Tahun</option>
                                        <option value="4 Tahun">4 Tahun</option>
                                        <option value="5 Tahun">5 Tahun</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="jpen_luas">Luas Pada Rencana Jangka Pendek</label>
                                    <input type="text" class="form-control" name="jpen_luas"
                                        placeholder="Masukkan Pada Rencana Jangka Pendek">
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
    var f1 = flatpickr(document.getElementById('basicFlatpickr2'));
    var f1 = flatpickr(document.getElementById('basicFlatpickr3'));
    var f1 = flatpickr(document.getElementById('basicFlatpickr4'));
</script>

@endpush