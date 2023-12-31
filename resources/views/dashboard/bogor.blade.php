@extends('layouts.app')

@section('title', 'Dashboard')

@push('styles')
<link href="{{ asset('plugins/apex/apexcharts.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('assets/css/dashboard/dash_1.css') }}" rel="stylesheet" type="text/css" />
@endpush

@section('content')
<div class="col-lg-12 layout-spacing">
    <div class="widget widget-chart-two">
        <div class="widget-heading">
            <h5 class="">Dashboard Wilayah Bogor</h5>
        </div>
        <div class="widget-content">
            <div class="row">
                <div class="col-xl-12">
                    <div class="chart-container">
                        <canvas id="suratPerProdiChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-lg-6 layout-spacing">
    <div class="widget-two">
        <div class="widget-content">
            {{-- @foreach($suratPerProdiCounts as $count) --}}
            <div class="w-numeric-value justify-content-start">
                <div class="w-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="feather feather-users">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                        <circle cx="9" cy="7" r="4"></circle>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                    </svg>
                </div>
                <div class="w-content ml-3">
                    {{-- <span class="w-value">{{ $count->total_surat }} Surat</span>
                    <span class="w-numeric-title">{{ $count->nama_prodi }}</span> --}}
                </div>
            </div>
            {{-- @endforeach --}}
        </div>
    </div>
</div>

<div class="col-lg-6 layout-spacing">
    <div class="widget widget-activity-three">
        <div class="widget-heading">
            <h5 class=""></h5>
        </div>
        <div class="widget-content">
            <div class="mt-container mx-auto">
                <div class="timeline-line">
                    {{-- @foreach($suratCounts as $prodi => $count) --}}
                    <div class="item-timeline timeline-primary">
                        <div class="t-dot">
                            <div class="t-primary"></div>
                        </div>
                        <div class="t-content">
                            <div class="t-uppercontent">
                                {{-- <h5>{{ $prodi }}</h5> --}}
                            </div>
                            {{-- <h6>{{ $count['printed'] ?? 0 }} Surat Sudah Di Print</h6>
                            <h6>{{ $count['unprinted'] ?? 0 }} Surat Belum Di Print</h6> --}}
                        </div>
                    </div>
                    {{-- @endforeach --}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
{{-- <script>
    var suratPerProdiData = @json($suratPerProdiCounts);

    var prodiLabels = suratPerProdiData.map(function (data) {
        return data.nama_prodi;
    });
    var suratCounts = suratPerProdiData.map(function (data) {
        return data.total_surat;
    });

    var ctx = document.getElementById('suratPerProdiChart').getContext('2d');
    var suratPerProdiChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: prodiLabels,
            datasets: [{
                label: 'Total Surat Magang',
                data: suratCounts,
                backgroundColor: [
                  'rgba(75, 192, 192, 0.6)',
                  'rgba(255, 99, 132, 0.6)',
                  'rgba(54, 162, 235, 0.6)',
                  'rgba(255, 206, 86, 0.6)',
                  'rgba(153, 102, 255, 0.6)',
                  'rgba(255, 159, 64, 0.6)',
                  'rgba(255, 99, 132, 0.6)',
                  'rgba(255, 205, 86, 0.6)',
                  'rgba(153, 102, 255, 0.6)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });
</script> --}}
@endpush