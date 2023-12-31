@extends('layouts.app')

@section('title', 'Edit Data Sebaran PNS/CPNS Menurut Tingkat golongan dan Jenis Kelamin ' . $semester)

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
                            <h4>Edit Data Sebaran PNS/CPNS Menurut Golongan dan Jenis Kelamin</h4>
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
                            <form
                                action="{{ route('pegawaigolongan.update', ['semester' => $semester, 'id' => $data->id]) }}"
                                method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="semester" value="{{ $semester }}">

                                <h6>Golongan IV</h6>
                                <div class="form-group">
                                    <label for="laki_iv">Laki IV</label>
                                    <input type="number" class="form-control" name="laki_iv"
                                        placeholder="Masukkan Laki IV" value="{{ $data->laki_iv }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="perempuan_iv">Perempuan IV</label>
                                    <input type="number" class="form-control" name="perempuan_iv"
                                        placeholder="Masukkan Perempuan IV" value="{{ $data->perempuan_iv }}" required>
                                </div>
                                <div class="thick-hr"></div>
                                <h6>Golongan III</h6>
                                <div class="form-group">
                                    <label for="laki_iii">Laki III</label>
                                    <input type="number" class="form-control" name="laki_iii"
                                        placeholder="Masukkan Laki III" value="{{ $data->laki_iii }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="perempuan_iii">Perempuan III</label>
                                    <input type="number" class="form-control" name="perempuan_iii"
                                        placeholder="Masukkan Perempuan III" value="{{ $data->perempuan_iii }}"
                                        required>
                                </div>
                                <div class="thick-hr"></div>
                                <h6>Golongan II</h6>
                                <div class="form-group">
                                    <label for="laki_ii">Laki II</label>
                                    <input type="number" class="form-control" name="laki_ii"
                                        placeholder="Masukkan Laki II" value="{{ $data->laki_ii }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="perempuan_ii">Perempuan II</label>
                                    <input type="number" class="form-control" name="perempuan_ii"
                                        placeholder="Masukkan Perempuan II" value="{{ $data->perempuan_ii }}" required>
                                </div>
                                <div class="thick-hr"></div>
                                <h6>Golongan I</h6>
                                <div class="form-group">
                                    <label for="laki_i">Laki I</label>
                                    <input type="number" class="form-control" name="laki_i"
                                        placeholder="Masukkan Laki I" value="{{ $data->laki_i }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="perempuan_i">Perempuan I</label>
                                    <input type="number" class="form-control" name="perempuan_i"
                                        placeholder="Masukkan Perempuan I" value="{{ $data->perempuan_i }}" required>
                                </div>
                                <div class="thick-hr"></div>
                                <h6>Jumlah</h6>
                                <div class="form-group">
                                    <label for="laki_jumlah">Laki Jumlah</label>
                                    <input type="number" class="form-control" name="laki_jumlah"
                                        placeholder="Masukkan Laki Jumlah" value="{{ $data->laki_jumlah }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="perempuan_jumlah">Perempuan Jumlah</label>
                                    <input type="number" class="form-control" name="perempuan_jumlah"
                                        placeholder="Masukkan Perempuan Jumlah" value="{{ $data->perempuan_jumlah }}"
                                        required>
                                </div>
                                <div class="thick-hr"></div>
                                <h6>Total</h6>
                                <div class="form-group">
                                    <label for="total">Total</label>
                                    <input type="number" class="form-control" name="total" placeholder="Masukkan Total"
                                        value="{{ $data->total }}" required>
                                </div>
                                <hr>
                                <div class="form-group">
                                    <label for="keterangan">Keterangan</label>
                                    <textarea class="form-control" name="keterangan" rows="3"
                                        placeholder="Masukkan keterangan (Optional)">{{ $data->keterangan }}</textarea>
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