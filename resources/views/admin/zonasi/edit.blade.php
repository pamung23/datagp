@extends('layouts.app')

@section('title', 'Edit Data Sebaran PNS/CPNS Menurut Tingkat Pendidikan dan Jenis Kelamin ' . $semester)

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
                            <h4>Penataan Kawasan Konservasi</h4>
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
                            <form action="{{ route('zonasi.update', ['semester' => $semester, 'id' => $data->id]) }}"
                                method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="semester" value="{{ $semester }}">
                                <h6>SK Penetapan Zonasi/Blok</h6>
                                <div class="form-group">
                                    <label for="nomor">Nomor</label>
                                    <input type="text" class="form-control" id="nomor" name="nomor"
                                        value="{{  $data->nomor }}" required>
                                    @error('nomor')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="tanggal">Tanggal</label>
                                    <input id="basicFlatpickr" class="form-control flatpickr flatpickr-input active"
                                        type="text" name="tanggal" value="{{ $data->tanggal}}" required>
                                    @error('tanggal')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="thick-hr"></div>
                                <h6>Zonasi/Blok (Ha)</h6>
                                <div class="form-group">
                                    <label for="inti">Inti</label>
                                    <input type="text" class="form-control zonasi" id="inti" name="inti"
                                        value="{{ $data->inti !== '0.00' ? number_format($data->inti, 2, ',', '.') : '0' }}"
                                        required>
                                    @error('inti')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="rimba">Rimba</label>
                                    <input type="text" class="form-control zonasi" id="rimba" name="rimba"
                                        value="{{ $data->rimba !== '0.00' ? number_format($data->rimba, 2, ',', '.') : '0' }}"
                                        required>
                                    @error('rimba')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="pemanfaatan">Pemanfaatan</label>
                                    <input type="text" class="form-control zonasi" id="pemanfaatan" name="pemanfaatan"
                                        value="{{ $data->pemanfaatan !== '0.00' ? number_format($data->pemanfaatan, 2, ',', '.') : '0' }}"
                                        required>
                                    @error('pemanfaatan')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="perlindungan">Perlindungan</label>
                                    <input type="text" class="form-control zonasi" id="perlindungan" name="perlindungan"
                                        value="{{ $data->perindungan !== '0.00' ? number_format($data->perindungan, 2, ',', '.') : '0' }}"
                                        required>
                                    @error('perlindungan')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="perlindungan_bahari">Perlindungan Bahari</label>
                                    <input type="text" class="form-control zonasi" id="perlindungan_bahari"
                                        name="perlindungan_bahari"
                                        value="{{ $data->perlindungan_bahari !== '0.00' ? number_format($data->perlindungan_bahari, 2, ',', '.') : '0' }}"
                                        required>
                                    @error('perlindungan_bahari')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="rehabilitasi">Rehabilitasi</label>
                                    <input type="text" class="form-control zonasi" id="rehabilitasi" name="rehabilitasi"
                                        value="{{ $data->rehabilitasi !== '0.00' ? number_format($data->rehabilitasi, 2, ',', '.') : '0' }}"
                                        required>
                                    @error('rehabilitasi')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="tradisional">Tradisional</label>
                                    <input type="text" class="form-control zonasi" id="tradisional" name="tradisional"
                                        value="{{ $data->tradisional !== '0.00' ? number_format($data->tradisional, 2, ',', '.') : '0' }}"
                                        required>
                                    @error('tradisional')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="religi">Religi, Budaya dan Sejarah</label>
                                    <input type="text" class="form-control zonasi" id="religi" name="religi"
                                        value="{{ $data->religi !== '0.00' ? number_format($data->religi, 2, ',', '.') : '0' }}"
                                        required>
                                    @error('religi')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="khusus">Khusus</label>
                                    <input type="text" class="form-control zonasi" id="khusus" name="khusus"
                                        value="{{ $data->khusus !== '0.00' ? number_format($data->khusus, 2, ',', '.') : '0' }}"
                                        required>
                                    @error('khusus')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="koleksi">Koleksi Tumbuhan/Satwa</label>
                                    <input type="text" class="form-control zonasi" id="koleksi" name="koleksi"
                                        value="{{ $data->koleksi !== '0.00' ? number_format($data->koleksi, 2, ',', '.') : '0' }}"
                                        required>
                                    @error('koleksi')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="lainnya">Lainnya</label>
                                    <input type="text" class="form-control zonasi" id="lainnya" name="lainnya"
                                        value="{{ $data->lainnya !== '0.00' ? number_format($data->lainnya, 2, ',', '.') : '0' }}"
                                        required>
                                    @error('lainnya')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="total">Total Luas (Ha)</label>
                                    <input type="text" class="form-control" id="total" name="total"
                                        value="{{ number_format($data->total, 2, ',', '.') }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="keterangan">Keterangan</label>
                                    <textarea class="form-control" name="keterangan" rows="3"
                                        placeholder="Masukkan keterangan (Optional)"> {{  $data->keterangan }}</textarea>
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
    function hitungTotalLuas() {
    let totalLuas = 0;
    $('.zonasi').each(function () {
        const value = parseFloat($(this).val().replace(/\./g, '').replace(/,/g, '.')) || 0;
        totalLuas += value;
    });

    // Tampilkan nilai total pada input total
    $('#total').val(totalLuas.toFixed(2)); // Menampilkan total dengan 2 digit di belakang koma
}

$('.zonasi').on('input', function () {
    hitungTotalLuas();
});

$(document).ready(function () {
    hitungTotalLuas(); // Hitung total saat halaman dimuat
});

</script>
@endpush