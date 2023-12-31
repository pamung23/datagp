@extends('layouts.app')

@section('title', 'Peralatan Tranportasi Pengendalian Kebakaran Hutan ' . $semester)

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
                            <h4>Peralatan Tranportasi Pengendalian Kebakaran Hutan</h4>
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
                                action="{{ route('peralatantransportasi.update', ['semester' => $semester, 'id' => $data->id]) }}"
                                method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="semester" value="{{ $semester }}">

                                <div class="thick-hr"></div>
                                <h6>Daops/Non Daops</h6>
                                <div class="thick-hr"></div>
                                <div class="form-group">
                                    <label for="daops">Daops/Non Daops</label>
                                    <input type="text" class="form-control" name="daops" value="{{ $data->daops }}"
                                        required>
                                </div>
                                <div class="thick-hr"></div>
                                <h6>Transportasi Darat (Unit)</h6>
                                <div class="thick-hr"></div>
                                <h6>Slip On Unit</h6>
                                <div class="form-group">
                                    <label for="baik1">Baik</label>
                                    <input type="number" class="form-control" name="baik1" value="{{ $data->baik1 }}"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="rusak1">Rusak</label>
                                    <input type="number" class="form-control" name="rusak1" value="{{ $data->rusak1 }}"
                                        required>
                                </div>
                                <h6>Monilog</h6>
                                <div class="form-group">
                                    <label for="baik2">Baik</label>
                                    <input type="number" class="form-control" name="baik2" value="{{ $data->baik2 }}"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="rusak2">Rusak</label>
                                    <input type="number" class="form-control" name="rusak2" value="{{ $data->rusak2 }}"
                                        required>
                                </div>
                                <h6>Sepeda Motor Patroli</h6>
                                <div class="form-group">
                                    <label for="baik3">Baik</label>
                                    <input type="number" class="form-control" name="baik3" value="{{ $data->baik3 }}"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="rusak3">Rusak</label>
                                    <input type="number" class="form-control" name="rusak3" value="{{ $data->rusak3 }}"
                                        required>
                                </div>
                                <h6>Mobil Patroli/Pick Up</h6>
                                <div class="form-group">
                                    <label for="baik4">Baik</label>
                                    <input type="number" class="form-control" name="baik4" value="{{ $data->baik4 }}"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="rusak4">Rusak</label>
                                    <input type="number" class="form-control" name="rusak4" value="{{ $data->rusak4 }}"
                                        required>
                                </div>
                                <h6>Mobil Operasional/ Pick Up</h6>
                                <div class="form-group">
                                    <label for="baik5">Baik</label>
                                    <input type="number" class="form-control" name="baik5" value="{{ $data->baik5 }}"
                                        required>
                                </div>
                                <div class="form-group">
                                    label for="rusak5">Rusak</label>
                                    <input type="number" class="form-control" name="rusak5" value="{{ $data->rusak5 }}"
                                        required>
                                </div>
                                <h6>Lain-Lain</h6>
                                <div class="form-group">
                                    <label for="lain1">Lain-Lain</label>
                                    <input type="number" class="form-control" name="lain1" value="{{ $data->lain1 }}"
                                        required>
                                </div>
                                <div class="thick-hr"></div>
                                <h6>Transportasi Air (Unit)</h6>
                                <div class="thick-hr"></div>
                                <h6>Boat</h6>
                                <div class="form-group">
                                    <label for="baik6">Baik</label>
                                    <input type="number" class="form-control" name="baik6" value="{{ $data->baik6 }}"
                                        required>
                                </div>
                                <div class="form-group">
                                    label for="rusak6">Rusak</label>
                                    <input type="number" class="form-control" name="rusak6" value="{{ $data->rusak6 }}"
                                        required>
                                </div>
                                <h6>Klotok</h6>
                                <div class="form-group">
                                    <label for="baik7">Baik</label>
                                    <input type="number" class="form-control" name="baik7" value="{{ $data->baik7 }}"
                                        required>
                                </div>
                                <div class="form-group">
                                    label for="rusak7">Rusak</label>
                                    <input type="number" class="form-control" name="rusak7" value="{{ $data->rusak7 }}"
                                        required>
                                </div>
                                <h6>Katinting</h6>
                                <div class="form-group">
                                    <label for="baik8">Baik</label>
                                    <input type="number" class="form-control" name="baik8" value="{{ $data->baik8 }}"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="rusak8">Rusak</label>
                                    <input type="number" class="form-control" name="rusak8" value="{{ $data->rusak8 }}"
                                        required>
                                </div>
                                <h6>Lain-Lain</h6>
                                <div class="form-group">
                                    <label for="lain2">Lain-Lain</label>
                                    <input type="number" class="form-control" name="lain2" value="{{ $data->lain2 }}"
                                        required>
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