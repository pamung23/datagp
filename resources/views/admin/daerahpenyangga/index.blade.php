@extends('layouts.app')

@section('title', 'Daerah Penyanggah Daerah Kawasan Konservasi')

@push('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('plugins/bootstrap-select/bootstrap-select.min.css') }}">
<link href="{{ asset('plugins/flatpickr/flatpickr.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('plugins/flatpickr/custom-flatpickr.css') }}" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="{{ asset('plugins/select2/select2.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('plugins/table/datatable/datatables.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('plugins/table/datatable/custom_dt_html5.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('plugins/table/datatable/dt-global_style.css') }}">
@endpush

@section('content')
<div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
    <div class="statbox widget box box-shadow">
        <div class="widget-header">
            <div class="row py-2 m-auto">
                <div class="col-xl-6 col-md-6 col-sm-6 col-6">
                    <h4>Daerah Penyanggah Daerah Kawasan Konservasi</h4>
                </div>
                <div class="col-xl-6 col-md-6 col-sm-6 col-6 text-right m-auto">
                    <a href="{{ route('daerahpenyangga.create') }}" class="btn btn-outline-primary btn-sm">Tambah
                        Data</a>
                </div>
            </div>
        </div>
        <div class="widget-content widget-content-area br-6">
            <form action="{{ route('daerahpenyangga.index') }}" method="GET" id="year-form" class="mb-4 ml-auto">
                <div class="form-group">
                    <select name="year" id="yearSelect" class="selectpicker" data-style="btn-outline-primary">
                        <option value="" selected>Pilih Tahun</option>
                        @foreach ($years as $yearOption)
                        <option value="{{ $yearOption }}" @if ($yearOption==$selectedYear) selected @endif>{{
                            $yearOption }}</option>
                        @endforeach
                    </select>
                </div>
                {{-- <button type="submit" class="btn btn-outline-primary btn-sm">Tampilkan Data</button> --}}
                <a href="{{ route('daerahpenyangga.export', ['year' => $selectedYear]) }}"
                    class="btn btn-outline-success btn-sm">Export to Excel</a>
            </form>
            <table id="zero-config" class="table table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Register Kawasan Kawasan Konservasi</th>
                        <th class="text-center">Daerah Penyangga Kawasan Konservasi</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
                    </tr>
                    <tr>
                        <th></th>
                        <th></th>
                        <th class="text-center">Kelurahan/Desa (ID Desa)</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($daerahPenyanggas as $data)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $data->no_register_kawasan }}</td>
                        <td>{{ $data->desa->desa }}</td>
                        <td>{{ $data->keterangan }}</td>
                        <td>
                            <a href="{{ route('daerahpenyangga.edit', $data->id) }}"
                                class="btn btn-outline-warning btn-sm">Edit</a>
                            <form action="{{ route('daerahpenyangga.destroy', $data->id) }}" method="POST"
                                class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm"
                                    onclick="return confirm('Yakin untuk menghapus data ini?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('plugins/table/datatable/datatables.js') }}"></script>
<script src="{{ asset('plugins/bootstrap-select/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('plugins/select2/select2.min.js') }}"></script>
<script src="{{ asset('plugins/select2/custom-select2.js') }}"></script>
<script src="{{ asset('plugins/flatpickr/flatpickr.js') }}"></script>
<script src="{{ asset('plugins/flatpickr/custom-flatpickr.js') }}"></script>
<script>
    $(document).ready(function () {
        $('#zero-config').DataTable({
            "dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" +
                "<'table-responsive'tr>" +
                "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
            "oLanguage": {
                "oPaginate": {
                    "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
                    "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>'
                },
                "sInfo": "Showing page _PAGE_ of _PAGES_",
                "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                "sSearchPlaceholder": "Search...",
                "sLengthMenu": "Results :  _MENU_",
            },
            "stripeClasses": [],
            "lengthMenu": [7, 10, 20, 50],
            "pageLength": 7
        });

        // Mengambil data kemitraan konservasi berdasarkan tahun yang dipilih oleh pengguna
        const yearSelect = document.getElementById('yearSelect');

        // Tambahkan event listener untuk perubahan nilai
        yearSelect.addEventListener('change', function () {
            // Simpan nilai tahun yang dipilih
            const selectedYear = yearSelect.value;

            // Ganti URL permintaan sesuai dengan tahun yang dipilih
            const baseUrl = "{{ route('daerahpenyangga.index') }}";
            const newUrl = `${baseUrl}?year=${selectedYear}`;

            // Arahkan ke URL baru
            window.location.href = newUrl;
        });
    });
</script>
@endpush