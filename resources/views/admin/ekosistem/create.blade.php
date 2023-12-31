@extends('layouts.app')

@section('title', 'Tambah Data Sebaran PNS/CPNS Menurut Tingkat Pendidikan dan Jenis Kelamin ' . $semester)

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
                            <h4>Ekosistem Kawasan Konservasi</h4>
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
                            <form action="{{ route('ekosistem.store', ['semester' => $semester]) }}" method="POST">
                                @csrf
                                <input type="hidden" name="semester" value="{{ $semester }}">
                                <div class="form-group" id="prasarana-container">
                                    <label>Ekosistem Kawasan Konservasi</label>

                                    <table class="table table-bordered table-responsive-lg" id="prasarana-table">
                                        <thead>
                                            <tr>
                                                <th class="col-md-8">Tipe Ekosistem</th>
                                                <th class="col-md-6 ">Luas</th>
                                                <th class="col-md-1">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="prasarana-item">
                                                <td>
                                                    <select name="tipe[]" class="form-control" required>
                                                        <option value="Ekosistem Hutan Pamah (Lowland Forest)">Ekosistem
                                                            Hutan Pamah (Lowland Forest)</option>
                                                        <option value="Hutan Pantai">Hutan Pantai</option>
                                                        <option value="Hutan Dipterokarpa">Hutan Dipterokarpa</option>
                                                        <!-- Tambahkan opsi lainnya sesuai kebutuhan -->
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="number" name="luas[]" class="form-control" step="0.01"
                                                        pattern="[0-9]+([\.,][0-9]+)?"
                                                        title="Masukkan angka desimal dengan menggunakan tanda titik sebagai pemisah"
                                                        required>

                                                </td>
                                                <td>
                                                    <button type="button"
                                                        class="btn btn-danger btn-remove">Hapus</button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <!-- Tombol Tambah -->
                                    <button type="button" class="btn btn-success btn-add">Tambah Prasarana</button>
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
    $(document).ready(function () {
        // Tombol Tambah Prasarana
        $(".btn-add").click(function () {
            var newRow = $(".prasarana-item:first").clone();
            newRow.find("input").val(""); // Kosongkan nilai input
            newRow.find(".btn-remove").show(); // Tampilkan tombol hapus pada baris baru
            $("#prasarana-table tbody").append(newRow);
        });

        // Tombol Hapus Prasarana
        $(document).on("click", ".btn-remove", function () {
            $(this).closest("tr").remove();
        });
    });
</script>
@endpush