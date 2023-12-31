@extends('layouts.app')

@section('title', 'Tambah Data Penataan Kawasan Konservasi ' . $semester)

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
                            <form action="{{ route('zonasi.store', ['semester' => $semester]) }}" method="POST">
                                @csrf
                                <input type="hidden" name="semester" value="{{ $semester }}">
                                <h6>SK Penetapan Zonasi/Blok</h6>
                                <div class="form-group">
                                    <label for="nomor">Nomor</label>
                                    <input type="text" class="form-control" id="nomor" name="nomor" required>
                                    @error('nomor')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="tanggal">Tanggal</label>
                                    <input id="basicFlatpickr" class="form-control flatpickr flatpickr-input active"
                                        type="text" placeholder="Pilih Tanggal.." id="tanggal" name="tanggal" required>
                                    @error('tanggal')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="thick-hr"></div>
                                <h6>Zonasi/Blok (Ha)</h6>
                                <div class="form-group">
                                    <label for="inti">Inti</label>
                                    <input type="text" class="form-control zonasi" id="inti" name="inti" required>
                                    @error('inti')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="rimba">Rimba</label>
                                    <input type="text" class="form-control zonasi" id="rimba" name="rimba" required>
                                    @error('rimba')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="pemanfaatan">Pemanfaatan</label>
                                    <input type="text" class="form-control zonasi" id="pemanfaatan" name="pemanfaatan"
                                        required>
                                    @error('pemanfaatan')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="perlindungan">Perlindungan</label>
                                    <input type="text" class="form-control zonasi" id="perlindungan" name="perlindungan"
                                        required>
                                    @error('perlindungan')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="perlindungan_bahari">Perlindungan Bahari</label>
                                    <input type="text" class="form-control zonasi" id="perlindungan_bahari"
                                        name="perlindungan_bahari" required>
                                    @error('perlindungan_bahari')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="rehabilitasi">Rehabilitasi</label>
                                    <input type="text" class="form-control zonasi" id="rehabilitasi" name="rehabilitasi"
                                        required>
                                    @error('rehabilitasi')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="tradisional">Tradisional</label>
                                    <input type="text" class="form-control zonasi" id="tradisional" name="tradisional"
                                        required>
                                    @error('tradisional')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="religi">Religi, Budaya dan Sejarah</label>
                                    <input type="text" class="form-control zonasi" id="religi" name="religi" required>
                                    @error('religi')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="khusus">Khusus</label>
                                    <input type="text" class="form-control zonasi" id="khusus" name="khusus" required>
                                    @error('khusus')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="koleksi">Koleksi Tumbuhan/Satwa</label>
                                    <input type="text" class="form-control zonasi" id="koleksi" name="koleksi" required>
                                    @error('koleksi')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="lainnya">Lainnya</label>
                                    <input type="text" class="form-control zonasi" id="lainnya" name="lainnya" required>
                                    @error('lainnya')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="total">Total Luas (Ha)</label>
                                    <input type="text" class="form-control" id="total" name="total" readonly>
                                </div>
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