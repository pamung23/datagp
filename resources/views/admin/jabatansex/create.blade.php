@extends('layouts.app')

@section('title', 'Sebaran PNS/CPNS Menurut Jabatan dan Jenis Kelamin ' . $semester)

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
                            <h4>Sebaran PNS/CPNS Menurut Jabatan dan Jenis Kelamin</h4>
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
                            <form action="{{ route('jabatansex.store', ['semester' => $semester]) }}" method="POST">
                                @csrf
                                <input type="hidden" name="semester" value="{{ $semester }}">

                                <div class="thick-hr"></div>
                                <h6>Struktural</h6>
                                <div class="thick-hr"></div>
                                <h6>I-A</h6>
                                <div class="form-group">
                                    <label for="laki_ia">Laki I-A</label>
                                    <input type="number" class="form-control" name="laki_ia"
                                        placeholder="Masukkan Laki I-A" required>
                                </div>
                                <div class="form-group">
                                    <label for="perempuan_ia">Perempuan I-A</label>
                                    <input type="number" class="form-control" name="perempuan_ia"
                                        placeholder="Masukkan Perempuan I-A" required>
                                </div>
                                <h6>I-B</h6>
                                <div class="form-group">
                                    <label for="laki_ib">Laki I-B</label>
                                    <input type="number" class="form-control" name="laki_ib"
                                        placeholder="Masukkan Laki I-B" required>
                                </div>
                                <div class="form-group">
                                    <label for="perempuan_ib">Perempuan I-B</label>
                                    <input type="number" class="form-control" name="perempuan_ib"
                                        placeholder="Masukkan Perempuan I-B" required>
                                </div>
                                <div class="thick-hr"></div>
                                <h6>II-A</h6>
                                <div class="form-group">
                                    <label for="laki_iia">Laki II-A</label>
                                    <input type="number" class="form-control" name="laki_iia"
                                        placeholder="Masukkan Laki II-A" required>
                                </div>
                                <div class="form-group">
                                    <label for="perempuan_iia">Perempuan II-A</label>
                                    <input type="number" class="form-control" name="perempuan_iia"
                                        placeholder="Masukkan Perempuan II-A" required>
                                </div>
                                <h6>II-B</h6>
                                <div class="form-group">
                                    <label for="laki_iib">Laki II-B</label>
                                    <input type="number" class="form-control" name="laki_iib"
                                        placeholder="Masukkan Laki II-B" required>
                                </div>
                                <div class="form-group">
                                    <label for="perempuan_iib">Perempuan II-B</label>
                                    <input type="number" class="form-control" name="perempuan_iib"
                                        placeholder="Masukkan Perempuan II-B" required>
                                </div>
                                <h6>III-A</h6>
                                <div class="form-group">
                                    <label for="laki_iiia">Laki III-A</label>
                                    <input type="number" class="form-control" name="laki_iiia"
                                        placeholder="Masukkan Laki III-A" required>
                                </div>
                                <div class="form-group">
                                    <label for="perempuan_iiia">Perempuan III-A</label>
                                    <input type="number" class="form-control" name="perempuan_iiia"
                                        placeholder="Masukkan Perempuan III-A" required>
                                </div>
                                <h6>III-B</h6>
                                <div class="form-group">
                                    <label for="laki_iiib">Laki III-B</label>
                                    <input type="number" class="form-control" name="laki_iiib"
                                        placeholder="Masukkan Laki III-B" required>
                                </div>
                                <div class="form-group">
                                    <label for="perempuan_iiib">Perempuan III-B</label>
                                    <input type="number" class="form-control" name="perempuan_iiib"
                                        placeholder="Masukkan Perempuan III-B" required>
                                </div>
                                <h6>III-C</h6>
                                <div class="form-group">
                                    <label for="laki_iiic">Laki III-C</label>
                                    <input type="number" class="form-control" name="laki_iiic"
                                        placeholder="Masukkan Laki III-C" required>
                                </div>
                                <div class="form-group">
                                    <label for="perempuan_iiic">Perempuan III-C</label>
                                    <input type="number" class="form-control" name="perempuan_iiic"
                                        placeholder="Masukkan Perempuan III-C" required>
                                </div>
                                <h6>III-D</h6>
                                <div class="form-group">
                                    <label for="laki_iiid">Laki III-D</label>
                                    <input type="number" class="form-control" name="laki_iiid"
                                        placeholder="Masukkan Laki III-D" required>
                                </div>
                                <div class="form-group">
                                    <label for="perempuan_iiid">Perempuan III-D</label>
                                    <input type="number" class="form-control" name="perempuan_iiid"
                                        placeholder="Masukkan Perempuan III-D" required>
                                </div>
                                <h6>IV-A</h6>
                                <div class="form-group">
                                    <label for="laki_iva">Laki IV-A</label>
                                    <input type="number" class="form-control" name="laki_iva"
                                        placeholder="Masukkan Laki IV-A" required>
                                </div>
                                <div class="form-group">
                                    <label for="perempuan_iva">Perempuan IV-A</label>
                                    <input type="number" class="form-control" name="perempuan_iva"
                                        placeholder="Masukkan Perempuan IV-A" required>
                                </div>
                                <h6>IV-B</h6>
                                <div class="form-group">
                                    <label for="laki_ivb">Laki IV-B</label>
                                    <input type="number" class="form-control" name="laki_ivb"
                                        placeholder="Masukkan Laki IV-B" required>
                                </div>
                                <div class="form-group">
                                    <label for="perempuan_ivb">Perempuan IV-B</label>
                                    <input type="number" class="form-control" name="perempuan_ivb"
                                        placeholder="Masukkan Perempuan IV-B" required>
                                </div>
                                <div class="thick-hr"></div>
                                <h6>Fungsional Umum</h6>
                                <div class="form-group">
                                    <label for="laki_umum">Laki Fungsional Umum</label>
                                    <input type="number" class="form-control" name="laki_umum"
                                        placeholder="Masukkan Laki Fungsional Umum" required>
                                </div>
                                <div class="form-group">
                                    <label for="perempuan_umum">Perempuan Fungsional Umum</label>
                                    <input type="number" class="form-control" name="perempuan_umum"
                                        placeholder="Masukkan Perempuan Fungsional Umum" required>
                                </div>
                                <div class="thick-hr"></div>
                                <h6>Fungsional Tertentu</h6>
                                <div class="form-group">
                                    <label for="laki_tertentu">Laki Fungsional Tertentu</label>
                                    <input type="number" class="form-control" name="laki_tertentu"
                                        placeholder="Masukkan Laki Fungsional Tertentu" required>
                                </div>
                                <div class="form-group">
                                    <label for="perempuan_tertentu">Perempuan tertentu</label>
                                    <input type="number" class="form-control" name="perempuan_tertentu"
                                        placeholder="Masukkan Perempuan tertentu" required>
                                </div>
                                <div class="thick-hr"></div>
                                <h6>Jumlah</h6>
                                <div class="form-group">
                                    <label for="laki_jumlah">Laki Jumlah</label>
                                    <input type="number" class="form-control" name="laki_jumlah"
                                        placeholder="Masukkan Laki Jumlah" required>
                                </div>
                                <div class="form-group">
                                    <label for="perempuan_jumlah">Perempuan Jumlah</label>
                                    <input type="number" class="form-control" name="perempuan_jumlah"
                                        placeholder="Masukkan Perempuan Jumlah" required>
                                </div>
                                <div class="thick-hr"></div>
                                <h6>Total</h6>
                                <div class="form-group">
                                    <label for="total">Total</label>
                                    <input type="number" class="form-control" name="total" placeholder="Masukkan Total"
                                        required>
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