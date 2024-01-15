@extends('layouts.app')

@section('title', 'Peralatan Mesin Pengendalian Kebakaran Hutan ' . $semester)

@push('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('plugins/bootstrap-select/bootstrap-select.min.css') }}">
<link href="{{ asset('plugins/flatpickr/flatpickr.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('plugins/flatpickr/custom-flatpickr.css') }}" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="{{ asset('plugins/select2/select2.min.css') }}">
<style>
    .thick-hr {
        border: none;
        border-top: 3px solid #000;
        margin: 10px 0;
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
                            <h4>Peralatan Mesin Pengendalian Kebakaran Hutan</h4>
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
                                action="{{ route('peralatanmesin.update', ['semester' => $semester, 'id' => $data->id]) }}"
                                method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="semester" value="{{ $semester }}">
                                <div class="form-group">
                                    <label for="daops">Daops/Non Daops</label>
                                    <input type="text" class="form-control" name="daops"
                                        placeholder="Masukkan Daops/Non Daops" value="{{ $data->daops }}" required>
                                </div>
                                <h6>Impuls Gun </h6>
                                <div class="form-group">
                                    <label for="baik1">Baik</label>
                                    <input type="number" class="form-control" name="baik1" placeholder="Masukkan Baik"
                                        value="{{ $data->baik1 }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="rusak1">Rusak</label>
                                    <input type="number" class="form-control" name="rusak1" placeholder="Masukkan Rusak"
                                        value="{{ $data->rusak1 }}" required>
                                </div>
                                <div class="thick-hr"></div>
                                <h6>Kompresor</h6>
                                <div class="form-group">
                                    <label for="baik2">Baik</label>
                                    <input type="number" class="form-control" name="baik2" placeholder="Masukkan Baik"
                                        value="{{ $data->baik2 }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="rusak2">Rusak</label>
                                    <input type="number" class="form-control" name="rusak2" placeholder="Masukkan Rusak"
                                        value="{{ $data->rusak2 }}" required>
                                </div>
                                <div class="thick-hr"></div>
                                <h6>Pompa Jinjing</h6>
                                <div class="form-group">
                                    <label for="baik3">Baik</label>
                                    <input type="number" class="form-control" name="baik3" placeholder="Masukkan Baik"
                                        value="{{ $data->baik3 }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="rusak3">Rusak</label>
                                    <input type="number" class="form-control" name="rusak3" placeholder="Masukkan Rusak"
                                        value="{{ $data->rusak3 }}" required>
                                </div>
                                <div class="thick-hr"></div>
                                <h6>Pompa Apung</h6>
                                <div class="form-group">
                                    <label for="baik4">Baik</label>
                                    <input type="number" class="form-control" name="baik4" placeholder="Masukkan Baik"
                                        value="{{ $data->baik4 }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="rusak4">Rusak</label>
                                    <input type="number" class="form-control" name="rusak4" placeholder="Masukkan Rusak"
                                        value="{{ $data->rusak4 }}" required>
                                </div>
                                <div class="thick-hr"></div>
                                <h6>Pompa Induk / Fix Pump</h6>
                                <div class="form-group">
                                    <label for="baik5">Baik</label>
                                    <input type="number" class="form-control" name="baik5" placeholder="Masukkan Baik"
                                        value="{{ $data->baik5 }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="rusak5">Rusak</label>
                                    <input type="number" class="form-control" name="rusak5" placeholder="Masukkan Rusak"
                                        value="{{ $data->rusak5 }}" required>
                                </div>
                                <div class="thick-hr"></div>
                                <h6>Pompa Sorong</h6>
                                <div class="form-group">
                                    <label for="baik6">Baik</label>
                                    <input type="number" class="form-control" name="baik6" placeholder="Masukkan Baik"
                                        value="{{ $data->baik6 }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="rusak6">Rusak</label>
                                    <input type="number" class="form-control" name="rusak6" placeholder="Masukkan Rusak"
                                        value="{{ $data->rusak6 }}" required>
                                </div>
                                <div class="thick-hr"></div>
                                <h6>Tangki Air Lipat</h6>
                                <div class="form-group">
                                    <label for="baik7">Baik</label>
                                    <input type="number" class="form-control" name="baik7" placeholder="Masukkan Baik"
                                        value="{{ $data->baik7 }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="rusak7">Rusak</label>
                                    <input type="number" class="form-control" name="rusak7" placeholder="Masukkan Rusak"
                                        value="{{ $data->rusak7 }}" required>
                                </div>
                                <div class="thick-hr"></div>
                                <h6>Selang Kirim</h6>
                                <h6>1,5'</h6>
                                <div class="form-group">
                                    <label for="baik8">Baik</label>
                                    <input type="number" class="form-control" name="baik8" placeholder="Masukkan Baik"
                                        value="{{ $data->baik8 }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="rusak8">Rusak</label>
                                    <input type="number" class="form-control" name="rusak8" placeholder="Masukkan Rusak"
                                        value="{{ $data->rusak8 }}" required>
                                </div>
                                <h6>2,5'</h6>
                                <div class="form-group">
                                    <label for="baik9">Baik</label>
                                    <input type="number" class="form-control" name="baik9" placeholder="Masukkan Baik"
                                        value="{{ $data->baik9 }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="rusak9">Rusak</label>
                                    <input type="number" class="form-control" name="rusak9" placeholder="Masukkan Rusak"
                                        value="{{ $data->rusak9 }}" required>
                                </div>
                                <div class="thick-hr"></div>
                                <h6>Nozel Variable</h6>
                                <h6>1,5'</h6>
                                <div class="form-group">
                                    <label for="baik10">Baik</label>
                                    <input type="number" class="form-control" name="baik10" placeholder="Masukkan Baik"
                                        value="{{ $data->baik10 }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="rusak10">Rusak</label>
                                    <input type="number" class="form-control" name="rusak10"
                                        placeholder="Masukkan Rusak" value="{{ $data->rusak10 }}" required>
                                </div>
                                <h6>2,5'</h6>
                                <div class="form-group">
                                    <label for="baik11">Baik</label>
                                    <input type="number" class="form-control" name="baik11" placeholder="Masukkan Baik"
                                        value="{{ $data->baik11 }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="rusak11">Rusak</label>
                                    <input type="number" class="form-control" name="rusak11"
                                        placeholder="Masukkan Rusak" value="{{ $data->rusak11 }}" required>
                                </div>
                                <div class="thick-hr"></div>
                                <h6>Check Valve</h6>
                                <div class="form-group">
                                    <label for="baik12">Baik</label>
                                    <input type="number" class="form-control" name="baik12" placeholder="Masukkan Baik"
                                        value="{{ $data->baik12 }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="rusak12">Rusak</label>
                                    <input type="number" class="form-control" name="rusak12"
                                        placeholder="Masukkan Rusak" value="{{ $data->rusak12 }}" required>
                                </div>
                                <div class="thick-hr"></div>
                                <h6>Sunbut</h6>
                                <div class="form-group">
                                    <label for="baik13">Baik</label>
                                    <input type="number" class="form-control" name="baik13" placeholder="Masukkan Baik"
                                        value="{{ $data->baik13 }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="rusak13">Rusak</label>
                                    <input type="number" class="form-control" name="rusak13"
                                        placeholder="Masukkan Rusak" value="{{ $data->rusak13 }}" required>
                                </div>
                                <h6>Pemasang Kopling</h6>
                                <div class="form-group">
                                    <label for="baik14">Baik</label>
                                    <input type="number" class="form-control" name="baik14" placeholder="Masukkan Baik"
                                        value="{{ $data->baik14 }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="rusak14">Rusak</label>
                                    <input type="number" class="form-control" name="rusak14"
                                        placeholder="Masukkan Rusak" value="{{ $data->rusak14 }}" required>
                                </div>
                                <h6>Pencuci Selang</h6>
                                <div class="form-group">
                                    <label for="baik15">Baik</label>
                                    <input type="number" class="form-control" name="baik15" placeholder="Masukkan Baik"
                                        value="{{ $data->baik15 }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="rusak15">Rusak</label>
                                    <input type="number" class="form-control" name="rusak15"
                                        placeholder="Masukkan Rusak" value="{{ $data->rusak15 }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="lain">Lain-Lain</label>
                                    <input type="text" class="form-control" name="lain" placeholder="Masukkan Lain-Lain"
                                        value="{{ $data->lain }}" required>
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