@extends('layouts.app')

@section('title', 'Tambah Data User')

@push('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('plugins/bootstrap-select/bootstrap-select.min.css') }}">
<link href="{{ asset('plugins/flatpickr/flatpickr.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('plugins/flatpickr/custom-flatpickr.css') }}" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="{{ asset('plugins/select2/select2.min.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css"
    crossorigin="anonymous" />


@endpush

@section('content')
<div class="container">
    <div class="row layout-top-spacing">
        <div id="basic" class="col-lg-12 layout-spacing">
            <div class="statbox widget box box-shadow">
                <div class="widget-header">
                    <div class="row">
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                            <h4>Tambah Data User</h4>
                        </div>
                    </div>
                </div>
                <div class="widget-content widget-content-area">
                    <div class="row">
                        <div class="col-lg-6 col-12 mx-auto">
                            @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                            <form method="POST" action="{{ route('user.store') }}">
                                @csrf
                                <div class="form-group">
                                    <label for="nama_lengkap">Nama Lengkap</label>
                                    <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap"
                                        required>
                                </div>

                                <div class="form-group">
                                    <label for="username">Username</label>
                                    <input type="text" class="form-control" id="username" name="username" required>
                                </div>

                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                                <div class="form-group">
                                    <label for="hp">Nomor Telepone</label>
                                    <input type="number" class="form-control" id="hp" name="hp" required>
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="password" name="password"
                                            required>
                                        <div class="input-group-append">
                                            <button type="button" id="togglePassword" class="btn btn-outline-secondary">
                                                <i class="fa fa-eye-slash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="level">Level</label>
                                    <select class="form-control" id="level" name="level" required>
                                        <option value="Admin">Admin</option>
                                        <option value="Balai">Balai</option>
                                        <option value="Wilayah Cianjur">Wilayah Cianjur</option>
                                        <option value="Wilayah Sukabumi">Wilayah Sukabumi</option>
                                        <option value="Wilayah Bogor">Wilayah Bogor</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="blokir">Blokir</label>
                                    <select class="form-control" id="blokir" name="blokir" required>
                                        <option value="Y">Yes</option>
                                        <option value="N">No</option>
                                    </select>
                                </div>
                                <div class="form-group resort-container">
                                    <label for="resort_id">Resort</label>
                                    <select class="form-control" id="resort_id" name="resort_id">
                                        <option value="" selected disabled>Pilih Resort (opsional)</option>
                                        @foreach ($resorts as $resort)
                                        <option value="{{ $resort->id }}">{{ $resort->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <button type="submit" class="btn btn-primary">Simpan</button>
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
<!-- JavaScript -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const passwordInput = document.getElementById('password');
        const togglePasswordButton = document.getElementById('togglePassword');

        togglePasswordButton.addEventListener('click', function () {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);

            // Ganti ikon mata terbuka/tertutup
            if (type === 'password') {
                togglePasswordButton.innerHTML = '<i class="fa fa-eye-slash"></i>';
            } else {
                togglePasswordButton.innerHTML = '<i class="fa fa-eye"></i>';
            }
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const levelSelect = document.getElementById('level');
        const resortContainer = document.querySelector('.resort-container');

        // Hide the Resort dropdown initially
        resortContainer.style.display = 'none';

        levelSelect.addEventListener('change', function () {
            const selectedLevel = levelSelect.value;

            // Show/hide the Resort dropdown based on the selected Level
            if (selectedLevel === 'Wilayah Cianjur' || selectedLevel === 'Wilayah Sukabumi' || selectedLevel === 'Wilayah Bogor') {
                resortContainer.style.display = 'block';
            } else {
                resortContainer.style.display = 'none';
            }
        });
    });
</script>
@endpush