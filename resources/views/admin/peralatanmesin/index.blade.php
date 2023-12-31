@extends('layouts.app')

@section('title', 'Peralatan Mesin Pengendalian Kebakaran Hutan')

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

                    <h4>Peralatan Mesin Pengendalian Kebakaran Hutan</h4>
                </div>
                <div class="col-xl-6 col-md-6 col-sm-6 col-6 text-right m-auto">
                    <a href="{{ route('peralatanmesin.create', ['semester' => $semester]) }}"
                        class="btn btn-outline-primary btn-sm">Tambah Data</a>
                </div>
            </div>
        </div>
        <div class="widget-content widget-content-area br-6">
            <form action="{{ route('peralatanmesin.index') }}" method="GET" class="mb-4 mt-3 ml-4">
                <div class="form-group d-flex">
                    <div class="mr-3">
                        <label for="semester">Semester:</label>
                        <select name="semester" id="semester" class="selectpicker" data-style="btn-outline-primary">
                            <option value="1" @if ($semester==1) selected @endif>Semester 1</option>
                            <option value="2" @if ($semester==2) selected @endif>Semester 2</option>
                        </select>
                    </div>
                    <div>
                        <label for="year">Tahun:</label>
                        <select name="year" id="year" class="selectpicker" data-style="btn-outline-primary">
                            <option value="" selected>Pilih Tahun</option>
                            @foreach ($uniqueYears as $uniqueYear)
                            <option value="{{ $uniqueYear }}" @if ($year==$uniqueYear) selected @endif>
                                {{ $uniqueYear }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="ml-auto mr-2">
                        @if ($year)
                        <a href="{{ route('peralatanmesin.export', ['semester' => $semester, 'year' => $year]) }}"
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
                        <th class="text-center">Satuan Kerja (Satker ID)</th>
                        <th class="text-center">Doaps/Non Doaps</th>
                        <th class="text-center" colspan="2">Impuls Gun</th>
                        <th class="text-center" colspan="2">Kompresor</th>
                        <th class="text-center" colspan="2">Pompa Jinjing</th>
                        <th class="text-center" colspan="2">Pompa Apung</th>
                        <th class="text-center" colspan="2">Pompa Induk / Fix Pump</th>
                        <th class="text-center" colspan="2">Pompa Sorong</th>
                        <th class="text-center" colspan="2">Tangki Air Lipat</th>
                        <th class="text-center" colspan="4">Selang Kirim</th>
                        <th class="text-center" colspan="4">Nozel Variable</th>
                        <th class="text-center" colspan="2">Check Valve</th>
                        <th class="text-center" colspan="2">Sunbut</th>
                        <th class="text-center" colspan="2">Pemasang Kopling</th>
                        <th class="text-center" colspan="2">Pencuci Selang</th>
                        <th class="text-center">Lain-lain</th>
                        <th class="text-center">Keterangan</th>
                        <th>action</th>

                    </tr>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th class="text-center" colspan="2">1,5'</th>
                        <th class="text-center" colspan="2">2,5'</th>
                        <th class="text-center" colspan="2">1,2'</th>
                        <th class="text-center" colspan="2">2,5'</th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th class="text-center">Baik</th>
                        <th class="text-center">Rusak </th>
                        <th class="text-center">Baik</th>
                        <th class="text-center">Rusak</th>
                        <th class="text-center">Baik</th>
                        <th class="text-center">Rusak</th>
                        <th class="text-center">Baik</th>
                        <th class="text-center">Rusak</th>
                        <th class="text-center">Baik</th>
                        <th class="text-center">Rusak</th>
                        <th class="text-center">Baik</th>
                        <th class="text-center">Rusak</th>
                        <th class="text-center">Baik</th>
                        <th class="text-center">Rusak</th>
                        <th class="text-center">Baik</th>
                        <th class="text-center">Rusak</th>
                        <th class="text-center">Baik</th>
                        <th class="text-center">Rusak</th>
                        <th class="text-center">Baik</th>
                        <th class="text-center">Rusak</th>
                        <th class="text-center">Baik</th>
                        <th class="text-center">Rusak</th>
                        <th class="text-center">Baik</th>
                        <th class="text-center">Rusak</th>
                        <th class="text-center">Baik</th>
                        <th class="text-center">Rusak</th>
                        <th class="text-center">Baik</th>
                        <th class="text-center">Rusak</th>
                        <th class="text-center">Baik</th>
                        <th class="text-center">Rusak</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($peralatan_mesin as $item)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td class="text-center">{{ $item->satker_id }}</td>
                        <td>{{ $item->daops }}</td>
                        <td>{{ $item->baik1 }}</td>
                        <td>{{ $item->rusak1 }}</td>
                        <td>{{ $item->baik2 }}</td>
                        <td>{{ $item->rusak2 }}</td>
                        <td>{{ $item->baik3 }}</td>
                        <td>{{ $item->rusak3 }}</td>
                        <td>{{ $item->baik4 }}</td>
                        <td>{{ $item->rusak4 }}</td>
                        <td>{{ $item->baik5 }}</td>
                        <td>{{ $item->rusak5 }}</td>
                        <td>{{ $item->baik6 }}</td>
                        <td>{{ $item->rusak6 }}</td>
                        <td>{{ $item->baik7 }}</td>
                        <td>{{ $item->rusak7 }}</td>
                        <td>{{ $item->baik8 }}</td>
                        <td>{{ $item->rusak8 }}</td>
                        <td>{{ $item->baik9 }}</td>
                        <td>{{ $item->rusak9 }}</td>
                        <td>{{ $item->baik10 }}</td>
                        <td>{{ $item->rusak10 }}</td>
                        <td>{{ $item->baik11 }}</td>
                        <td>{{ $item->rusak11 }}</td>
                        <td>{{ $item->baik12 }}</td>
                        <td>{{ $item->rusak12 }}</td>
                        <td>{{ $item->baik13 }}</td>
                        <td>{{ $item->rusak13 }}</td>
                        <td>{{ $item->baik14 }}</td>
                        <td>{{ $item->rusak14 }}</td>
                        <td>{{ $item->baik15 }}</td>
                        <td>{{ $item->rusak15 }}</td>
                        <td>{{ $item->lain }}</td>
                        <td>{{ $item->keterangan }}</td>
                        <td>
                            <a href="{{ route('peralatanmesin.edit', ['semester' => $semester, 'id' => $item->id]) }}"
                                class="btn btn-outline-warning btn-sm" class="text-center">Edit</a>
                            <form
                                action="{{ route('peralatanmesin.destroy', ['semester' => $semester, 'id' => $item->id]) }}"
                                method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm"
                                    onclick="return confirm('Yakin untuk menghapus data ini?')"
                                    class="text-center">Hapus</button>
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
</script>
<script>
    // Ambil elemen select semester
        const semesterSelect = document.getElementById('semester');
        // Ambil elemen select tahun
        const yearSelect = document.getElementById('year');
        // Ambil elemen tombol "Export to Excel"
        const excelButton = document.getElementById('excel-button');

        // Tambahkan event listener untuk perubahan nilai semester
        semesterSelect.addEventListener('change', function() {
            // Simpan nilai semester yang dipilih
            const selectedsemester = semesterSelect.value;

            // Dapatkan tahun saat ini yang dipilih
            const selectedYear = yearSelect.value;

            // Ganti URL permintaan sesuai dengan semester dan tahun yang dipilih
            const baseUrl = "{{ route('peralatanmesin.index') }}";
            const newUrl = `${baseUrl}?semester=${selectedsemester}&year=${selectedYear}`;

            // Arahkan ke URL baru
            window.location.href = newUrl;
        });

        // Tambahkan event listener untuk perubahan nilai tahun
        yearSelect.addEventListener('change', function() {
            // Simpan nilai tahun yang dipilih
            const selectedYear = yearSelect.value;

            // Aktifkan tombol "Export to Excel" hanya jika tahun dipilih
            if (selectedYear) {
                // Dapatkan semester saat ini yang dipilih
                const selectedsemester = semesterSelect.value;

                // Ganti URL permintaan sesuai dengan semester dan tahun yang dipilih
                const baseUrl = "{{ route('peralatanmesin.index') }}";
                const newUrl = `${baseUrl}?semester=${selectedsemester}&year=${selectedYear}`;

                // Arahkan ke URL baru
                window.location.href = newUrl;
            }
            // Sembunyikan tombol "Export to Excel" jika tahun tidak dipilih
            excelButton.style.display = selectedYear ? 'block' : 'none';
        });
</script>
@endpush