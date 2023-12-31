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
                            <h4>Edit Data Perencanaan Pengelolaan Kawasan Konservasi</h4>
                        </div>
                    </div>
                </div>
                <div class="widget-content widget-content-area">
                    <div class="row">
                        <div class="col-lg-6 col-12 mx-auto">
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
                                action="{{ route('perencanaanpkk.update', ['semester' => $semester, 'id' => $data->id]) }}"
                                method="POST">
                                @csrf
                                @method('PUT')
                                <div class="thick-hr"></div>
                                <h6>Rencana Pengelolaan Jangka Panjang</h6>
                                <div class="form-group">
                                    <label for="jpan_nomor">Nomor Jangka Panjang</label>
                                    <input type="text" class="form-control" name="jpan_nomor"
                                        placeholder="Masukkan Nomor Jangka Panjang" value="{{ $data->jpan_nomor }}"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="jpan_tanggal">Tanggal Jangka Panjang</label>
                                    <input type="date" class="form-control" name="jpan_tanggal"
                                        value="{{ $data->jpan_tanggal }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="jpan_mulai">Mulai Jangka Panjang</label>
                                    <input type="date" class="form-control" name="jpan_mulai"
                                        value="{{ $data->jpan_mulai }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="jpan_akhir">Akhir Jangka Panjang</label>
                                    <input type="date" class="form-control" name="jpan_akhir"
                                        value="{{ $data->jpan_akhir }}" required>
                                </div>
                                <!-- Lanjutkan formulir dengan data lainnya -->
                                <div class="thick-hr"></div>
                                <h6>Rencana Pengelolaan Jangka Pendek</h6>
                                <div class="form-group">
                                    <label for="jpen_nomor">Nomor Jangka Pendek</label>
                                    <input type="text" class="form-control" name="jpen_nomor"
                                        placeholder="Masukkan Nomor Jangka Pendek" value="{{ $data->jpen_nomor }}"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="jpen_tanggal">Tanggal Jangka Pendek</label>
                                    <input type="date" class="form-control" name="jpen_tanggal"
                                        value="{{ $data->jpen_tanggal }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="jpen_periode">Periode Jangka Pendek</label>
                                    <select class="form-control" name="jpen_periode" required>
                                        <option value="1 Tahun" {{ $data->jpen_periode == '1 Tahun' ? 'selected' : ''
                                            }}>1 Tahun</option>
                                        <option value="2 Tahun" {{ $data->jpen_periode == '2 Tahun' ? 'selected' : ''
                                            }}>2 Tahun</option>
                                        <option value="3 Tahun" {{ $data->jpen_periode == '3 Tahun' ? 'selected' : ''
                                            }}>3 Tahun</option>
                                        <option value="4 Tahun" {{ $data->jpen_periode == '4 Tahun' ? 'selected' : ''
                                            }}>4 Tahun</option>
                                        <option value="5 Tahun" {{ $data->jpen_periode == '5 Tahun' ? 'selected' : ''
                                            }}>5 Tahun</option>
                                    </select>
                                </div>

                                <hr>
                                <div class="form-group">
                                    <label for="keterangan">Keterangan</label>
                                    <textarea class="form-control" name="keterangan" rows="3"
                                        placeholder="Masukkan keterangan (Optional)">{{ $data->keterangan }}</textarea>
                                </div>
                                <button type="submit" class="btn btn-primary mt-4" id="submit-button">Simpan
                                    Perubahan</button>
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