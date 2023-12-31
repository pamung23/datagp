@extends('layouts.app')

@section('title', 'Dashboard')

@push('styles')
<link href="{{ asset('plugins/apex/apexcharts.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('assets/css/dashboard/dash_1.css') }}" rel="stylesheet" type="text/css" />
@endpush

@section('content')
<div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
  <div style="background-color: #3162c4" class="widget widget-chart-two">
    <div style="text-align:center;" class="widget-heading">
      <h3 style="color: white" class=""><strong>SELAMAT DATANG </strong>
      </h3>
      <H3 style="color: white">{{ Auth::user()->nama_lengkap}}</H3>
      <H3 style="color: white"><STRONG>DI SISTEM INFORMASI DATA GEPANG</STRONG></H3>
      <img style="width: 50%;"
        src="https://gedepangrango.org/wp-content/uploads/2022/04/Logo-diatas-dan-lebel-dibawah-1-1.png"
        class="navbar-logo" alt="logo">
      <br>
      <p style="color: white"><strong>Silahkan input data sesuai dengan kewenangan Anda</strong></p>
      <br>

    </div>
  </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush