@extends('layouts.app')

@section('title', 'Peralatan tangan Pengendalian Kebakaran Hutan ' . $semester)

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
                            <h4>Tambah Data Peralatan tangan Pengendalian Kebakaran Hutan</h4>
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
                            <form action="{{ route('peralatantangan.store', ['semester' => $semester]) }}"
                                method="POST">
                                @csrf
                                <input type="hidden" name="semester" value="{{ $semester }}">

                                <h6>Sekop</h6>
                                <div class="form-group">
                                    <label for="baik1">Baik</label>
                                    <input type="number" class="form-control" name="baik1" placeholder="Masukkan Baik"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="rusak1">Rusak</label>
                                    <input type="number" class="form-control" name="rusak1" placeholder="Masukkan Rusak"
                                        required>
                                </div>
                                <div class="thick-hr"></div>
                                <h6>Garu</h6>
                                <div class="form-group">
                                    <label for="baik2">Baik</label>
                                    <input type="number" class="form-control" name="baik2" placeholder="Masukkan Baik"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="rusak2">Rusak</label>
                                    <input type="number" class="form-control" name="rusak2" placeholder="Masukkan Rusak"
                                        required>
                                </div>
                                <div class="thick-hr"></div>
                                <h6>Garu Tajam</h6>
                                <div class="form-group">
                                    <label for="baik3">Baik</label>
                                    <input type="number" class="form-control" name="baik3" placeholder="Masukkan Baik"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="rusak3">Rusak</label>
                                    <input type="number" class="form-control" name="rusak3" placeholder="Masukkan Rusak"
                                        required>
                                </div>
                                <div class="thick-hr"></div>
                                <h6>Kapak 2 Fungsi Pulaski</h6>
                                <div class="form-group">
                                    <label for="baik4">Baik</label>
                                    <input type="number" class="form-control" name="baik4" placeholder="Masukkan Baik"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="rusak4">Rusak</label>
                                    <input type="number" class="form-control" name="rusak4" placeholder="Masukkan Rusak"
                                        required>
                                </div>
                                <div class="thick-hr"></div>
                                <h6>Gepyok</h6>
                                <div class="form-group">
                                    <label for="baik5">Baik</label>
                                    <input type="number" class="form-control" name="baik5" placeholder="Masukkan Baik"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="rusak5">Rusak</label>
                                    <input type="number" class="form-control" name="rusak5" placeholder="Masukkan Rusak"
                                        required>
                                </div>
                                <div class="thick-hr"></div>
                                <h6>Cangkul</h6>
                                <div class="form-group">
                                    <label for="baik6">Baik</label>
                                    <input type="number" class="form-control" name="baik6" placeholder="Masukkan Baik"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="rusak6">Rusak</label>
                                    <input type="number" class="form-control" name="rusak6" placeholder="Masukkan Rusak"
                                        required>
                                </div>
                                <div class="thick-hr"></div>
                                <h6>Golok</h6>
                                <div class="form-group">
                                    <label for="baik7">Baik</label>
                                    <input type="number" class="form-control" name="baik7" placeholder="Masukkan Baik"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="rusak7">Rusak</label>
                                    <input type="number" class="form-control" name="rusak7" placeholder="Masukkan Rusak"
                                        required>
                                </div>
                                <div class="thick-hr"></div>
                                <h6>Pengait Semak</h6>
                                <div class="form-group">
                                    <label for="baik8">Baik</label>
                                    <input type="number" class="form-control" name="baik8" placeholder="Masukkan Baik"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="rusak8">Rusak</label>
                                    <input type="number" class="form-control" name="rusak8" placeholder="Masukkan Rusak"
                                        required>
                                </div>
                                <div class="thick-hr"></div>
                                <h6>Obor Sulut tetes</h6>
                                <div class="form-group">
                                    <label for="baik9">Baik</label>
                                    <input type="number" class="form-control" name="baik9" placeholder="Masukkan Baik"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="rusak9">Rusak</label>
                                    <input type="number" class="form-control" name="rusak9" placeholder="Masukkan Rusak"
                                        required>
                                </div>
                                <div class="thick-hr"></div>
                                <h6>jet Shooter</h6>
                                <div class="form-group">
                                    <label for="baik10">Baik</label>
                                    <input type="number" class="form-control" name="baik10" placeholder="Masukkan Baik"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="rusak10">Rusak</label>
                                    <input type="number" class="form-control" name="rusak10"
                                        placeholder="Masukkan Rusak" required>
                                </div>
                                <div class="thick-hr"></div>
                                <h6>Kikir</h6>
                                <div class="form-group">
                                    <label for="baik11">Baik</label>
                                    <input type="number" class="form-control" name="baik11" placeholder="Masukkan Baik"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="rusak11">Rusak</label>
                                    <input type="number" class="form-control" name="rusak11"
                                        placeholder="Masukkan Rusak" required>
                                </div>
                                <div class="thick-hr"></div>
                                <h6>Chainsaw</h6>
                                <div class="form-group">
                                    <label for="baik12">Baik</label>
                                    <input type="number" class="form-control" name="baik12" placeholder="Masukkan Baik"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="rusak12">Rusak</label>
                                    <input type="number" class="form-control" name="rusak12"
                                        placeholder="Masukkan Rusak" required>
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