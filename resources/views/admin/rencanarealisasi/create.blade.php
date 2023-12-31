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
                            <h4>Tambah Rencana Realisasi Ekosistem Kawasan Konservasi</h4>
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
                            <form action="{{ route('rencanarealisasi.store') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="metode_pe">Metode PE:</label>
                                    <select name="metode_pe" class="form-control" required>
                                        <option>Pilih Metode Pemulihan Ekosistem...</option>
                                        <option value="Suksesi Alami">Suksesi Alami</option>
                                        <option value="Rehabilitasi">Rehabilitasi</option>
                                        <option value="Restorasi">Restorasi</option>
                                    </select>
                                    <div class="form-group">
                                        <label for="target_ha">Target PE (Ha):</label>
                                        <input type="number" name="target_ha" class="form-control" step="0.01"
                                            placeholder="Target PE" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="luas_ha">Luas Realisasi Pemulihan Ekosistem (Ha):</label>
                                        <input type="number" name="luas_ha" class="form-control" step="0.01"
                                            placeholder="Luas Realisasi Pemulihan Ekosistem" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="persentase_keberhasilan">Persentase Keberhasilan (%):</label>
                                        <input type="number" name="persentase_keberhasilan" class="form-control"
                                            step="0.01" placeholder="Persentase Keberhasilan">
                                    </div>
                                    <div class="form-group">
                                        <label for="sumber_pembiayaan">Sumber Pembiayaan:</label>
                                        <input type="text" name="sumber_pembiayaan" class="form-control"
                                            placeholder="Sumber Pembiayaan">
                                    </div>
                                    <div class="form-group">
                                        <label for="keterangan">Keterangan:</label>
                                        <input type="text" name="keterangan" class="form-control"
                                            placeholder="Keterangan">
                                    </div>
                                    <button type="submit" class="btn btn-primary mt-4">Simpan</button>
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
    // Hide/show fields based on selected method
    const metodePeSelect = document.querySelector('select[name="metode_pe"]');
    const persentaseKeberhasilanField = document.querySelector('input[name="persentase_keberhasilan"]');
    const sumberKeberhasilanField = document.querySelector('input[name="sumber_keberhasilan"]');
    
    metodePeSelect.addEventListener('change', function() {
        if (this.value === 'Suksesi Alami') {
            persentaseKeberhasilanField.value = ''; // Clear the field
            persentaseKeberhasilanField.setAttribute('readonly', true);
            sumberKeberhasilanField.value = ''; // Clear the field
            sumberKeberhasilanField.setAttribute('readonly', true);
        } else if (this.value === 'Restorasi') {
            persentaseKeberhasilanField.value = ''; // Clear the field
            persentaseKeberhasilanField.setAttribute('readonly', true);
            sumberKeberhasilanField.removeAttribute('readonly');
        } else {
            persentaseKeberhasilanField.removeAttribute('readonly');
            sumberKeberhasilanField.removeAttribute('readonly');
        }
    });
</script>
@endpush