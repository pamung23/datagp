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
                            <h4>Edit Rencana Realisasi Ekosistem Kawasan Konservasi</h4>
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
                            <form action="{{ route('rencanarealisasi.update', $rencanaRealisasi->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="form-group">
                                    <label for="metode_pe">Metode PE:</label>
                                    <select name="metode_pe" class="form-control" required>
                                        <option value="Suksesi Alami" {{ $rencanaRealisasi->metode_pe === 'Suksesi
                                            Alami' ? 'selected' : '' }}>Suksesi Alami</option>
                                        <option value="Rehabilitasi" {{ $rencanaRealisasi->metode_pe === 'Rehabilitasi'
                                            ? 'selected' : '' }}>Rehabilitasi</option>
                                        <option value="Restorasi" {{ $rencanaRealisasi->metode_pe === 'Restorasi' ?
                                            'selected' : '' }}>Restorasi</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="target_ha">Target PE (Ha):</label>
                                    <input type="number" name="target_ha" class="form-control" step="0.01"
                                        placeholder="Target PE" value="{{ $rencanaRealisasi->target_ha }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="luas_ha">Luas Realisasi Pemulihan Ekosistem (Ha):</label>
                                    <input type="number" name="luas_ha" class="form-control" step="0.01"
                                        placeholder="Luas Realisasi Pemulihan Ekosistem"
                                        value="{{ $rencanaRealisasi->luas_ha }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="persentase_keberhasilan">Persentase Keberhasilan (%):</label>
                                    <input type="number" name="persentase_keberhasilan" class="form-control" step="0.01"
                                        placeholder="Persentase Keberhasilan"
                                        value="{{ $rencanaRealisasi->persentase_keberhasilan }}" {{
                                        $rencanaRealisasi->metode_pe === 'Suksesi Alami' || $rencanaRealisasi->metode_pe
                                    === 'Restorasi' ? 'readonly' : '' }}>
                                </div>
                                <div class="form-group">
                                    <label for="sumber_pembiayaan">Sumber Pembiayaan:</label>
                                    <input type="text" name="sumber_pembiayaan" class="form-control"
                                        placeholder="Sumber Pembiayaan"
                                        value="{{ $rencanaRealisasi->sumber_pembiayaan }}">
                                </div>
                                <div class="form-group">
                                    <label for="keterangan">Keterangan:</label>
                                    <textarea name="keterangan" class="form-control" rows="3"
                                        placeholder="Keterangan">{{ $rencanaRealisasi->keterangan }}</textarea>
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
<script>
    // Hide/show fields based on selected method
    const metodePeSelect = document.querySelector('select[name="metode_pe"]');
    const persentaseKeberhasilanField = document.querySelector('input[name="persentase_keberhasilan"]');
    
    metodePeSelect.addEventListener('change', function() {
        if (this.value === 'Suksesi Alami' || this.value === 'Restorasi') {
            persentaseKeberhasilanField.value = ''; // Clear the field
            persentaseKeberhasilanField.setAttribute('readonly', true);
        } else {
            persentaseKeberhasilanField.removeAttribute('readonly');
        }
    });
</script>
@endpush