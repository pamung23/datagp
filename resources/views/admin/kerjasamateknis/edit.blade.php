@extends('layouts.app')

@section('title', 'Edit Data Kerjasama Teknis Bidang KSDAE ' . $semester)

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
                            <h4>Edit Kerjasama Teknis Bidang KSDAE</h4>
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
                            <form
                                action="{{ route('kerjasamateknis.update', ['semester' => $semester, 'id' => $data->id]) }}"
                                method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="semester" value="{{ $semester }}">
                                <div class="form-group">
                                    <label for="mitra_kerja">Mitra Kerja Sama</label>
                                    <input type="text" class="form-control" id="mitra_kerja" name="mitra_kerja"
                                        value="{{ $data->mitra_kerja }}" required>
                                    @error('mitra_kerja')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="tipe_mitra">Tipe Mitra</label>
                                    <input type="text" class="form-control" id="tipe_mitra" name="tipe_mitra"
                                        value="{{ $data->tipe_mitra }}" required>
                                    @error('tipe_mitra')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="jenis_kerja_sama">Jenis Kerja Sama</label>
                                    <input type="text" class="form-control" id="jenis_kerja_sama"
                                        value="{{ $data->jenis_kerja_sama }}" name="jenis_kerja_sama" required>
                                    @error('jenis_kerja_sama')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="judul_kerja_sama">Judul Kerja Sama</label>
                                    <input type="text" class="form-control" id="judul_kerja_sama"
                                        value="{{ $data->judul_kerja_sama }}" name="judul_kerja_sama" required>
                                    @error('judul_kerja_sama')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="ruang_lingkup_kerja_sama">Ruang Lingkup Kerja Sama</label>
                                    <input type="text" class="form-control" id="ruang_lingkup_kerja_sama"
                                        value="{{ $data->ruang_lingkup_kerja_sama }}" name="ruang_lingkup_kerja_sama"
                                        required>
                                    @error('ruang_lingkup_kerja_sama')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="no_mou_pks">No MoU/PKS</label>
                                    <input type="text" class="form-control" id="no_mou_pks" name="no_mou_pks"
                                        value="{{ $data->no_mou_pks }}" required>
                                    @error('no_mou_pks')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="tanggal_mou_pks">Tanggal MoU/PKS</label>
                                    <input id="basicFlatpickr" class="form-control flatpickr flatpickr-input active"
                                        type="text" placeholder="Pilih Tanggal MoU/PKS" id=" tanggal_mou_pks"
                                        name="tanggal_mou_pks" value="{{ $data->tanggal_mou_pks }}" required>
                                    @error('tanggal_mou_pks')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="persetujuan_kerja_sama">Persetujuan Kerja Sama</label>
                                    <input type="text" class="form-control" id="persetujuan_kerja_sama"
                                        value="{{ $data->no_mou_pks }}" name="persetujuan_kerja_sama" required>
                                    @error('persetujuan_kerja_sama')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="tanggal_awal_berlaku">Tanggal Awal Berlaku</label>
                                    <input id="basicFlatpickr1" class="form-control flatpickr flatpickr-input active"
                                        type="text" placeholder="Pilih Tanggal Awal Berlaku.." id="tanggal_awal_berlaku"
                                        value="{{ $data->tanggal_awal_berlaku }}" name="tanggal_awal_berlaku" required>
                                    @error('tanggal_awal_berlaku')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="tanggal_akhir_berlaku">Tanggal Akhir Berlaku</label>
                                    <input id="basicFlatpickr2" class="form-control flatpickr flatpickr-input active"
                                        type="text" placeholder="Pilih Tanggal Akhir Berlaku.."
                                        value="{{ $data->tanggal_akhir_berlaku }}" id="tanggal_akhir_berlaku"
                                        name="tanggal_akhir_berlaku" required>
                                    @error('tanggal_akhir_berlaku')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="lokasi_kerja_konservasi">Lokasi Kerja Sama (Kawasan Konservasi)</label>
                                    <input type="text" class="form-control" id="lokasi_kerja_konservasi"
                                        value="{{ $data->lokasi_kerja_konservasi }}" name="lokasi_kerja_konservasi"
                                        required>
                                    @error('lokasi_kerja_konservasi')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="lokasi_kerja_provinsi">Lokasi Kerja Sama (Provinsi)</label>
                                    <input type="text" class="form-control" id="lokasi_kerja_provinsi"
                                        value="{{ $data->lokasi_kerja_provinsi }}" name="lokasi_kerja_provinsi"
                                        required>
                                    @error('lokasi_kerja_provinsi')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="luas_areal_kerja_sama">Luas Areal Kerja Sama</label>
                                    <input type="text" class="form-control" id="luas_areal_kerja_sama"
                                        value="{{ $data->luas_areal_kerja_sama }}" name="luas_areal_kerja_sama"
                                        required>
                                    @error('luas_areal_kerja_sama')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="komitmen_pendanaan">Komitmen Pendanaan</label>
                                    <input type="text" class="form-control" id="komitmen_pendanaan"
                                        value="{{ $data->komitmen_pendanaan }}" name="komitmen_pendanaan" required>
                                    @error('komitmen_pendanaan')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="ikp_ikk_berkaitan">IKP/IKK yang Berkaitan dengan MoU/PKS</label>
                                    <input type="text" class="form-control" id="ikp_ikk_berkaitan"
                                        value="{{ $data->ikp_ikk_berkaitan }}" name="ikp_ikk_berkaitan" required>
                                    @error('ikp_ikk_berkaitan')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="status_kerja_sama">Status Kerja Sama</label>
                                    <input type="text" class="form-control" id="status_kerja_sama"
                                        value="{{ $data->status_kerja_sama }}" name="status_kerja_sama" required>
                                    @error('status_kerja_sama')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
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
<script>
    var f1 = flatpickr(document.getElementById('basicFlatpickr1'));
    var f1 = flatpickr(document.getElementById('basicFlatpickr2'));
</script>
@endpush