@extends('layouts.app')

@section('title', 'Kawasan Konservasi')

@push('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('plugins/table/datatable/datatables.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('plugins/table/datatable/custom_dt_html5.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('plugins/table/datatable/dt-global_style.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('plugins/bootstrap-select/bootstrap-select.min.css') }}">
<link href="{{ asset('plugins/flatpickr/flatpickr.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('plugins/flatpickr/custom-flatpickr.css') }}" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="{{ asset('plugins/select2/select2.min.css') }}">
<!-- END PAGE LEVEL CUSTOM STYLES -->
@endpush

@section('content')

<div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
    <div class="statbox widget box box-shadow">
        <div class="widget-header">
            <div class="row py-2 m-auto">
                <div class="col-xl-6 col-md-6 col-sm-6 col-6">
                    <h4>Kawasan Konservasi</h4>
                </div>
                @if($triwulan !== 'all')
                <div class="col-xl-6 col-md-6 col-sm-6 col-6 text-right m-auto">
                    <a href="{{ route('penetapankk.create', ['triwulan' => $triwulan]) }}"
                        class="btn btn-outline-primary btn-sm">Tambah Data</a>
                </div>
                @endif
            </div>
        </div>

        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif
        @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
        @endif
        <div class="widget-content widget-content-area br-6">
            <form action="{{ route('penetapankk.index') }}" method="GET" class="mb-4 mt-3 ml-4">
                <div class="form-group d-flex">
                    <div class="mr-3">
                        <label for="triwulan">Triwulan:</label>
                        <select name="triwulan" id="triwulan" class="selectpicker" data-style="btn-outline-primary">
                            <option value="1" @if($triwulan==1) selected @endif>Triwulan 1</option>
                            <option value="2" @if($triwulan==2) selected @endif>Triwulan 2</option>
                            <option value="3" @if($triwulan==3) selected @endif>Triwulan 3</option>
                            <option value="4" @if($triwulan==4) selected @endif>Triwulan 4</option>
                            <option value="all" @if($triwulan=="all" ) selected @endif>All</option>
                        </select>
                    </div>
                    <div>
                        <label for="year">Tahun:</label>
                        <select name="year" id="year" class="selectpicker" data-style="btn-outline-primary">
                            <option value="" selected>Pilih Tahun</option>
                            @foreach($uniqueYears->unique() as $uniqueYear)
                            <option value="{{ $uniqueYear }}" @if($year==$uniqueYear) selected @endif>{{ $uniqueYear }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="ml-auto mr-2">
                        @if ($year)
                        <a href="{{ route('penetapankk.export', ['triwulan' => $triwulan, 'year' => $year]) }}"
                            class="btn btn-outline-success btn-sm">Export to Excel</a>
                        @else
                        <button class="btn btn-outline-success btn-sm" disabled>Export to Excel</button>
                        <span class="text-danger ml-2">Pilih tahun terlebih dahulu.</span>
                        @endif
                    </div>
                </div>
            </form>
            <table id="zero-config" class="table table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Register Kawasan Konservasi</th>
                        <th>Resort</th>
                        <th colspan="3" class="text-center">Penunjukan Parsial</th>
                        <th colspan="3" class="text-center">Penunjukan Per Provinsi</th>
                        <th colspan="3" class="text-center">Penetapan Kawasan</th>
                        <th>Penambah Data</th>
                        <th>Keterangan</th>
                        @if($triwulan !== 'all')
                        <th>Aksi</th>
                        @endif
                    </tr>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th>Nomor SK</th>
                        <th>Tanggal SK</th>
                        <th>Luas (Ha)</th>
                        <th>Nomor SK</th>
                        <th>Tanggal SK</th>
                        <th>Luas (Ha)</th>
                        <th>Nomor SK</th>
                        <th>Tanggal SK</th>
                        <th>Luas (Ha)</th>
                        <th></th>
                        <th></th>
                        @if($triwulan !== 'all')
                        <th></th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach ($penetapankk as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->no_register_kawasan }}</td>
                        <td>
                            @if ($item->user && $item->user->resort)
                            {{ $item->user->resort->nama }}
                            @else
                            Unknown Resort
                            @endif
                        </td>
                        <td>{{ $item->nomor_sk_parsial }}</td>
                        <td>{{ $item->tanggal_sk_parsial }}</td>
                        <td>{{ $item->luas_ha_parsial }}</td>
                        <td>{{ $item->nomor_sk_provinsi }}</td>
                        <td>{{ $item->tanggal_sk_provinsi }}</td>
                        <td>{{ $item->luas_ha_provinsi }}</td>
                        <td>{{ $item->nomor_sk_kawasan }}</td>
                        <td>{{ $item->tanggal_sk_kawasan }}</td>
                        <td>{{ $item->luas_ha_kawasan }}</td>
                        <td class="text-center">{{ $item->user ? $item->user->nama_lengkap : 'Unknown User' }}</td>
                        <td>{{ $item->keterangan }}</td>
                        @if($triwulan !== 'all')
                        <td>
                            <a href="{{ route('penetapankk.edit', ['triwulan' => $triwulan, 'id' => $item->id]) }}"
                                class="btn btn-outline-warning btn-sm">Edit</a>
                            <form
                                action="{{ route('penetapankk.destroy', ['triwulan' => $triwulan, 'id' => $item->id]) }}"
                                method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm"
                                    onclick="return confirm('Yakin untuk menghapus data ini?')">Hapus</button>
                            </form>
                        </td>
                        @endif
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

    // Ambil elemen select triwulan
    const triwulanSelect = document.getElementById('triwulan');
    // Ambil elemen select tahun
    const yearSelect = document.getElementById('year');
    // Ambil elemen tombol "Export to Excel"
    const excelButton = document.getElementById('excel-button');

    // Tambahkan event listener untuk perubahan nilai triwulan
    triwulanSelect.addEventListener('change', function () {
        // Simpan nilai triwulan yang dipilih
        const selectedTriwulan = triwulanSelect.value;

        // Dapatkan tahun saat ini yang dipilih
        const selectedYear = yearSelect.value;

        // Ganti URL permintaan sesuai dengan triwulan dan tahun yang dipilih
        const baseUrl = "{{ route('penetapankk.index') }}";
        const newUrl = `${baseUrl}?triwulan=${selectedTriwulan}&year=${selectedYear}`;

        // Arahkan ke URL baru
        window.location.href = newUrl;
    });

   // Tambahkan event listener untuk perubahan nilai tahun
yearSelect.addEventListener('change', function () {
    // Simpan nilai tahun yang dipilih
    const selectedYear = yearSelect.value;

    // Aktifkan tombol "Export to Excel" hanya jika tahun dipilih
    if (selectedYear) {
        // Dapatkan triwulan saat ini yang dipilih
        const selectedTriwulan = triwulanSelect.value;

        // Ganti URL permintaan sesuai dengan triwulan dan tahun yang dipilih
        const baseUrl = "{{ route('penetapankk.index') }}";
        const newUrl = `${baseUrl}?triwulan=${selectedTriwulan}&year=${selectedYear}`;

        // Arahkan ke URL baru
        window.location.href = newUrl;
    }
    // Sembunyikan tombol "Export to Excel" jika tahun tidak dipilih
    excelButton.style.display = selectedYear ? 'block' : 'none';
});

</script>
@endpush