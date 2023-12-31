@extends('layouts.app')

@section('title', 'Potensi Wisata Alam di Kawasan Konservasi')

@push('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('plugins/table/datatable/datatables.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('plugins/table/datatable/custom_dt_html5.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('plugins/table/datatable/dt-global_style.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('plugins/bootstrap-select/bootstrap-select.min.css') }}">
<link href="{{ asset('plugins/flatpickr/flatpickr.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('plugins/flatpickr/custom-flatpickr.css') }}" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="{{ asset('plugins/select2/select2.min.css') }}">
@endpush

@section('content')
<div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
    <div class="statbox widget box box-shadow">
        <div class="widget-header">
            <div class="row py-2 m-auto">
                <div class="col-xl-6 col-md-6 col-sm-6 col-6">
                    <h4>Potensi Wisata Alam di Kawasan Konservasi</h4>
                </div>
                @if($triwulan !== 'all')
                <div class="col-xl-6 col-md-6 col-sm-6 col-6 text-right m-auto">
                    <a href="{{ route('potensiodtwa.create', ['triwulan' => $triwulan]) }}"
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
            <form action="{{ route('potensiodtwa.index') }}" method="GET" class="mb-4 mt-3 ml-4">
                <div class="form-group d-flex">
                    <div class="mr-3 float-left">
                        <label for="triwulan"></label>
                        <select name="triwulan" id="triwulan" class="selectpicker" data-style="btn-outline-primary">
                            <option value="1" @if($triwulan==1) selected @endif>Triwulan 1</option>
                            <option value="2" @if($triwulan==2) selected @endif>Triwulan 2</option>
                            <option value="3" @if($triwulan==3) selected @endif>Triwulan 3</option>
                            <option value="4" @if($triwulan==4) selected @endif>Triwulan 4</option>
                            <option value="all" @if($triwulan=="all" ) selected @endif>All</option>
                        </select>
                    </div>
                    <div>
                        <label for="year"></label>
                        <select name="year" id="year" class="selectpicker" data-style="btn-outline-primary">
                            <option value="" selected>Pilih Tahun</option>
                            @foreach($uniqueYears->unique() as $uniqueYear)
                            <option value="{{ $uniqueYear }}" @if($year==$uniqueYear) selected @endif>{{ $uniqueYear }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="ml-auto mr-2 ">
                        @if ($year)
                        <a href="{{ route('potensiodtwa.export', ['triwulan' => $triwulan, 'year' => $year]) }}"
                            class="btn btn-outline-success btn-sm">Export to Excel</a>
                        @else
                        <button class="btn btn-outline-success btn-sm" disabled>Export to Excel</button>
                        <span class="text-danger ml-2">Pilih tahun terlebih dahulu.</span>
                        @endif
                    </div>
                    <div class="float-left mr-2">
                        <a href="{{ route('potensiodtwa.petaall') }}" class="btn btn-outline-primary btn-sm">
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-map">
                                    <polygon points="1 6 1 22 8 18 16 22 23 18 23 2 16 6 8 2 1 6"></polygon>
                                    <line x1="8" y1="2" x2="8" y2="18"></line>
                                    <line x1="16" y1="6" x2="16" y2="22"></line>
                                </svg>
                            </div>
                        </a>
                    </div>
                </div>
            </form>

            <div class="table-responsive">
                <table id="zero-config" class="table table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Register Kawasan Konservasi</th>
                            <th>Resort</th>
                            <th class="text-center">Nama Zona</th>
                            <th class="text-center">Luas Zona(Ha)</th>
                            <th class="text-center" colspan="5">ODTWA</th>
                            <th class="text-center" colspan="3">Sarana dan Prasarana yang Tersedia</th>
                            <th class="text-center">Pengusahaan oleh Pihak III</th>
                            <th>Penambah Data</th>
                            <th class="text-center">Keterangan</th>
                            @if($triwulan !== 'all')
                            <th class="text-center">Aksi</th>
                            @endif
                        </tr>
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th class="text-center">Jenis ODTWA</th>
                            <th class="text-center" colspan="3">Kordinat Geografis</th>
                            <th class="text-center">Jenis Atraksi Wisata</th>
                            <th class="text-center">Jenis Sarana dan Prasarana</th>
                            <th class="text-center">Jumlah (Unit)</th>
                            <th class="text-center">Kondisi</th>
                            <th></th>
                            <th></th>
                            <th></th>
                            @if($triwulan !== 'all')
                            <th></th>
                            @endif
                        </tr>
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th class="text-center">Latitude</th>
                            <th class="text-center">Longitude</th>
                            <th>Letak</th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            @if($triwulan !== 'all')
                            <th></th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($potensiodtwa as $item)
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
                            <td>{{ $item->nama_zona_blok_pemanfaatan }}</td>
                            <td>{{ $item->luas_zona_blok_pemanfaatan }}</td>
                            <td>{{ $item->jenis_odtwa}}</td>
                            <td>{{ $item->latitude}}</td>
                            <td>{{ $item->longitude }}</td>
                            <td>
                                <a href="{{ route('potensiodtwa.peta', ['triwulan' => $triwulan, 'id' => $item->id, 'latitude' => $item->latitude, 'longitude' => $item->longitude]) }}"
                                    class="btn btn-outline-primary btn-sm">
                                    <div>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" class="feather feather-map">
                                            <polygon points="1 6 1 22 8 18 16 22 23 18 23 2 16 6 8 2 1 6"></polygon>
                                            <line x1="8" y1="2" x2="8" y2="18"></line>
                                            <line x1="16" y1="6" x2="16" y2="22"></line>
                                        </svg>
                                    </div>
                                </a>
                            </td>

                            <td>{{ $item->jenis_atraksi_wisata }}</td>
                            <!-- Loop melalui data prasarana -->
                            <td>
                                @foreach ($item->jenis_prasarana as $jenisPrasarana)
                                {{ $jenisPrasarana }}<br>
                                @endforeach
                            </td>
                            <td>
                                @foreach ($item->jenis_prasarana as $index => $jenisPrasarana)
                                {{ $jenisPrasarana }} ({{ $item->jumlah_unit[$index] }}),<br>
                                @endforeach
                            </td>

                            <td>
                                @foreach ($item->kondisi as $kondisi)
                                {{ $kondisi }}<br>
                                @endforeach
                            </td>
                            <td>{{ $item->pengusahaan_oleh_pihak_iii }}</td>
                            <td class="text-center">{{ $item->user ? $item->user->nama_lengkap : 'Unknown User' }}</td>
                            <td>{{ $item->keterangan }}</td>
                            @if($triwulan !== 'all')
                            <td>
                                <a href=" {{ route('potensiodtwa.edit', ['triwulan'=> $triwulan, 'id' => $item->id]) }}"
                                    class="btn btn-outline-warning btn-sm">Edit</a>
                                <form
                                    action="{{ route('potensiodtwa.destroy', ['triwulan' => $triwulan, 'id' => $item->id]) }}"
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
    $(document).ready(function() {
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
    });

    // Ambil elemen select triwulan
    const triwulanSelect = document.getElementById('triwulan');
    // Ambil elemen select tahun
    const yearSelect = document.getElementById('year');

    // Tambahkan event listener untuk perubahan nilai triwulan
    triwulanSelect.addEventListener('change', function () {
        // Simpan nilai triwulan yang dipilih
        const selectedTriwulan = triwulanSelect.value;

        // Dapatkan tahun saat ini yang dipilih
        const selectedYear = yearSelect.value;

        // Ganti URL permintaan sesuai dengan triwulan dan tahun yang dipilih
        const baseUrl = "{{ route('potensiodtwa.index') }}";
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
            const baseUrl = "{{ route('potensiodtwa.index') }}";
            const newUrl = `${baseUrl}?triwulan=${selectedTriwulan}&year=${selectedYear}`;

            // Arahkan ke URL baru
            window.location.href = newUrl;
        }
    });
</script>
@endpush