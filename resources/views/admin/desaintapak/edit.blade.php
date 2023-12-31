@extends('layouts.app')

@push('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('plugins/bootstrap-select/bootstrap-select.min.css') }}">
<link href="{{ asset('plugins/flatpickr/flatpickr.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('plugins/flatpickr/custom-flatpickr.css') }}" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="{{ asset('plugins/select2/select2.min.css') }}">
@endpush

@section('content')
<div class="container">
    <div class="row layout-top-spacing">
        <div class="col-lg-12 layout-spacing">
            <div class="statbox widget box box-shadow">
                <div class="widget-header">
                    <div class="row">
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                            <h4>Edit Data Desain Tapak Pemanfaatan Jasa Lingkungan Wisata Alam</h4>
                        </div>
                    </div>
                </div>
                <div class="widget-content widget-content-area">
                    @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                    @endif

                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <div class="row">
                        <div class="col-lg-6 col-12 mx-auto">
                            <form action="{{ route('desaintapak.update', $desainTapak->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <!-- Atur metode HTTP PUT -->
                                <div class="form-group">
                                    <input type="hidden" name="no_register_kawasan" class="form-control"
                                        value="{{ $desainTapak->no_register_kawasan }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="nama_zona_blok_pemanfaatan">Nama Zona/Blok Pemanfaatan</label>
                                    <input type="text" name="nama_zona_blok_pemanfaatan" class="form-control"
                                        value="{{ $desainTapak->nama_zona_blok_pemanfaatan }}" required>
                                </div>
                                <div class=" form-group">
                                    <label for="luas_zona_blok_pemanfaatan">Luas Zona/Blok Pemanfaatan (Ha)</label>
                                    <input type="number" name="luas_zona_blok_pemanfaatan" class="form-control"
                                        value="{{ $desainTapak->luas_zona_blok_pemanfaatan }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="ruang_publik">Ruang Publik (Ha)</label>
                                    <input type="number" name="ruang_publik" class="form-control"
                                        value="{{ $desainTapak->ruang_publik }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="ruang_usaha">Ruang Usaha (Ha)</label>
                                    <input type="number" name="ruang_usaha" class="form-control"
                                        value="{{ $desainTapak->ruang_usaha }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="keterangan">Keterangan</label>
                                    <input type="text" name="keterangan" class="form-control"
                                        value="{{ $desainTapak->keterangan }}">
                                </div>
                                <!-- Tambahkan elemen formulir lainnya sesuai kebutuhan -->
                                <button type="submit" class="btn btn-primary mt-4">Simpan Perubahan</button>
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
    $(document).ready(function () {
        // Inisialisasi Select2
        $('.select2').select2();
    });
</script>
@endpush