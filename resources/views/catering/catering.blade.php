@extends('layouts.main-site')

@push('styles')
    <!-- Animation CSS -->
    <link rel="stylesheet" href="/assets/css/animate.css">	
    <!-- Latest Bootstrap min CSS -->
    <link rel="stylesheet" href="/assets/bootstrap/css/bootstrap.min.css">
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css?family=Kaushan+Script&amp;display=swap" rel="stylesheet"> 
    <link href="https://fonts.googleapis.com/css?family=Josefin+Sans:100,100i,300,300i,400,400i,600,600i,700,700i&amp;display=swap" rel="stylesheet"> 
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i&amp;display=swap" rel="stylesheet"> 

    <link rel="stylesheet" href="/assets/css/animate.css">	
    <link rel="stylesheet" href="/assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/all.min.css">
    <link rel="stylesheet" href="/assets/css/ionicons.min.css">
    <link rel="stylesheet" href="/assets/css/themify-icons.css">
    <link rel="stylesheet" href="/assets/css/linearicons.css">
    <link rel="stylesheet" href="/assets/css/flaticon.css">
    <link rel="stylesheet" href="/assets/owlcarousel/css/owl.carousel.min.css">
    <link rel="stylesheet" href="/assets/owlcarousel/css/owl.theme.default.min.css">
    <link rel="stylesheet" href="/assets/css/slick.css">
    <link rel="stylesheet" href="/assets/css/slick-theme.css">
    <link rel="stylesheet" href="/assets/css/magnific-popup.css">
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/css/responsive.css">
    <link id="layoutstyle" rel="stylesheet" href="/assets/color/theme-red.css">
@endpush

@section('title', 'Katering')

@section('header')
<header class="header_wrap fixed-top header_with_topbar light_skin main_menu_uppercase">
    <div class="container">
        @include('partials.nav')
    </div>
</header>
@endsection

@section('content')

<!-- BREADCRUMB -->
<div class="breadcrumb_section background_bg overlay_bg_50 page_title_light" data-img-src="/assets/images/cta2_bg.png">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title">
                    <h1>Katering</h1>
                </div>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active">Katering</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<!-- SECTION CATERING MENU -->
<div class="section pb_70">
    <div class="container">

        @if(!$category)
            <p class="text-center">Tidak ada kategori Katering</p>
        @else
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="heading_tab_header">
                    <div class="heading_s1">
                        <h2>{{ $category->name }}</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            @forelse ($category->menus as $menu)
                <div class="d-flex col-lg-3 col-sm-6">
                    <div class="single_product">
                        <a href="{{ route('menu.item', $menu->id) }}">

                            @if ($menu->stock > 0)
                                <div class="menu_product_img">
                                    <img src="{{ asset('storage/' . $menu->image) }}" alt="{{ $menu->name }}">
                                </div>
                            @else
                                <div style="position: relative; filter: grayscale(80%);">
                                    <img src="{{ asset('storage/' . $menu->image) }}" alt="{{ $menu->name }}">
                                    <span style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background: #ff0000; color: #fff; padding: 5px 10px; font-size: 12px; font-weight: bold; border-radius: 4px; white-space: nowrap;">
                                        SOLD OUT
                                    </span>
                                </div>
                            @endif

                        </a>

                        <div class="menu_product_info">
                            <h5><a href="{{ route('menu.item', $menu->id) }}">{{ $menu->name }}</a></h5>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="price">{!! $site_settings->currency_symbol !!}{{ number_format($menu->price, 2) }}</span>
                                @if($menu->stock > 0)
                                    <small class="text-success">{{ $menu->stock }} porsi tersisa</small>
                                @else
                                    <small class="text-danger">Habis</small>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <p>Tidak ada Katering</p>
            @endforelse
        </div>
        @endif

    </div>
</div>

@endsection

@push('scripts')
<script src="/assets/js/jquery-1.12.4.min.js"></script> 
<script src="/assets/bootstrap/js/bootstrap.min.js"></script> 
<script src="/assets/owlcarousel/js/owl.carousel.min.js"></script> 
<script src="/assets/js/magnific-popup.min.js"></script> 
<script src="/assets/js/slick.min.js"></script>
<script src="/assets/js/scripts.js"></script>
@endpush
