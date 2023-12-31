@extends('layouts.app')

@section('title', 'Detail Kemitraan Konservasi')

@section('content')
<div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
    <div class="widget widget-content widget-content-area">
        <h5>Detail Kemitraan Konservasi</h5>
        <div class="row">
            <div class="col-12">
                <p><strong>Nomor Register:</strong> {{ $kemitraankonservasi->nomor_register }}</p>
                <p><strong>Kelurahan/Desa:</strong> {{ $kemitraankonservasi->desa->desa }}</p>
                <p><strong>Nama Kelompok:</strong> {{ $kemitraankonservasi->nama_kelompok }}</p>
                <p><strong>Jumlah Anggota:</strong> {{ $kemitraankonservasi->jumlah_anggota }}</p>
                <p><strong>Luas PKS (Ha):</strong> {{ $kemitraankonservasi->luas_pks }}</p>
                <p><strong>Zona/Blok:</strong> {{ $kemitraankonservasi->zona_blok }}</p>
                <p><strong>Bentuk Kemitraan:</strong> {{ $kemitraankonservasi->bentuk_kemitraan }}</p>
                <p><strong>Nilai Ekonomi per Tahun (Rp):</strong> Rp. {{
                    number_format($kemitraankonservasi->nilai_ekonomi_per_tahun, 2, ',', '.') }}</p>
                <p><strong>Keterangan:</strong> {{ $kemitraankonservasi->keterangan }}</p>
                <a href="{{ route('kemitraankonservasi.index') }}" class="btn btn-primary">Kembali</a>
            </div>
        </div>
    </div>
</div>
@endsection