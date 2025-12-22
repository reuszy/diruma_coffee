@extends('layouts.main-site')

@section('title', 'Ubah Password')

@push('styles')
    <!-- Latest Bootstrap min CSS -->
    <link rel="stylesheet" href="/assets/bootstrap/css/bootstrap.min.css">
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css?family=Kaushan+Script&amp;display=swap" rel="stylesheet"> 
    <link href="https://fonts.googleapis.com/css?family=Josefin+Sans:100,100i,300,300i,400,400i,600,600i,700,700i&amp;display=swap" rel="stylesheet"> 
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i&amp;display=swap" rel="stylesheet"> 
    <!-- Icon Font CSS -->
    <link rel="stylesheet" href="/assets/css/all.min.css">
    <link rel="stylesheet" href="/assets/css/ionicons.min.css">
    <link rel="stylesheet" href="/assets/css/themify-icons.css">
    <link rel="stylesheet" href="/assets/css/linearicons.css">
    <link rel="stylesheet" href="/assets/css/flaticon.css">
    <!-- Style CSS -->
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/css/responsive.css">
    <link id="layoutstyle" rel="stylesheet" href="/assets/color/theme-red.css">
@endpush

@section('header')
    <header class="header_wrap fixed-top header_with_topbar light_skin main_menu_uppercase">
        <div class="container">
            @include('partials.nav')
        </div>
    </header>
@endsection

@section('content')

<div class="breadcrumb_section background_bg overlay_bg_50 page_title_light"
     data-img-src="/assets/images/blog_diruma.png">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title">
                <h1>Ubah Password</h1>
                </div>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active">Ubah Password</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="section py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7">

                @if(session('success'))
                    <div class="alert alert-success text-center">
                        <i class="ti-check-box mr-1"></i> {{ session('success') }}
                    </div>
                @endif

                <div class="card border-0 shadow">
                    {{-- HEADER --}}
                    <div class="card-body text-center border-bottom py-4">
                        <div class="mb-3">
                            <span class="badge badge-success rounded-circle p-3">
                                <i class="ti-lock" style="font-size: 20px;"></i>
                            </span>
                        </div>
                        <h5 class="font-weight-bold mb-1">Ganti Password</h5>
                        <p class="text-muted mb-0" style="font-size: 14px;">
                            Pastikan password baru kamu aman!
                        </p>
                    </div>

                    {{-- FORM --}}
                    <div class="card-body px-4 py-4">
                        <form method="POST" action="{{ route('customer.update-password') }}">
                            @csrf
                            @method('PUT')

                            {{-- Password Lama --}}
                            <div class="form-group">
                                <label class="small font-weight-bold text-muted">
                                    Password Saat Ini
                                </label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-light">
                                            <i class="ti-key"></i>
                                        </span>
                                    </div>
                                    <input type="password"
                                           name="current_password"
                                           class="form-control"
                                           placeholder="Masukkan password saat ini"
                                           required>
                                </div>
                                @error('current_password')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- Password Baru --}}
                            <div class="form-group">
                                <label class="small font-weight-bold text-muted">
                                    Password Baru
                                </label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-light">
                                            <i class="ti-lock"></i>
                                        </span>
                                    </div>
                                    <input type="password"
                                           name="new_password"
                                           class="form-control"
                                           placeholder="Minimal 8 karakter"
                                           required>
                                </div>
                                @error('new_password')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- Konfirmasi --}}
                            <div class="form-group mb-4">
                                <label class="small font-weight-bold text-muted">
                                    Konfirmasi Password Baru
                                </label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-light">
                                            <i class="ti-check"></i>
                                        </span>
                                    </div>
                                    <input type="password"
                                           name="new_password_confirmation"
                                           class="form-control"
                                           placeholder="Ulangi password baru"
                                           required>
                                </div>
                            </div>

                            {{-- BUTTON --}}
                            <button type="submit"
                                    class="btn btn-success btn-block font-weight-bold">
                                <i class="ti-save mr-1"></i> Simpan Password
                            </button>
                        </form>
                    </div>

                    {{-- FOOTER --}}
                    <div class="card-footer bg-white text-center border-0 pb-4">
                        <a href="{{ route('home') }}"
                           class="text-muted small">
                            <i class="ti-arrow-left mr-1"></i> Kembali ke Website
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
    <script src="/assets/js/jquery-1.12.4.min.js"></script> 
    <script src="/assets/bootstrap/js/bootstrap.min.js"></script> 
    <script src="/assets/js/scripts.js"></script>
@endpush