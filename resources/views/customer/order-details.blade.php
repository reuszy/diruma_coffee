@extends('layouts.main-site')

@section('title', 'Detail Pesanan')

@push('styles')
    <link rel="stylesheet" href="/assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/css/responsive.css">
    <link id="layoutstyle" rel="stylesheet" href="/assets/color/theme-red.css">
    <link rel="stylesheet" href="/assets/css/all.min.css">
    <link rel="stylesheet" href="/assets/css/ionicons.min.css">
    <link rel="stylesheet" href="/assets/css/linearicons.css">
@endpush

@section('header')
    <header class="header_wrap fixed-top header_with_topbar light_skin main_menu_uppercase">
        <div class="container">
            @include('partials.nav')
        </div>
    </header>
@endsection

@section('content')

<div class="breadcrumb_section background_bg overlay_bg_50 page_title_light" data-img-src="/assets/images/menu_diruma.jpg">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title">
                    <h1>Detail Pesanan</h1>
                </div>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('customer.dashboard') }}">Akun Saya</a></li>
                    <li class="breadcrumb-item active">Order #{{ $order->order_no }}</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="section">
    <div class="container">
        
        <div class="row mb-4">
            <div class="col-12 d-flex flex-wrap justify-content-between align-items-center">
                <div>
                    <h3 class="font-weight-bold">Order #{{ $order->order_no }}</h3>
                    <p class="text-muted mb-0"><i class="linearicons-clock"></i> Dibuat pada: {{ $order->created_at->format('d M Y, H:i') }} WIB</p>
                </div>
                <div>
                     @if($order->status_online_pay == 'unpaid' && $order->status != 'cancelled')
                        <a href="{{ route('customer.repay', $order->id) }}" class="btn btn-success btn-lg rounded-0 shadow-sm">
                            <i class="ion-card mr-2"></i> Bayar Sekarang
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-4 mb-3">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body">
                        <h6 class="text-muted text-uppercase small font-weight-bold">Status Pesanan</h6>
                        <div class="mt-2">
                            @if($order->status == 'pending')
                                <h5 class="text-warning font-weight-bold"><i class="fa fa-clock mr-2"></i> Menunggu</h5>
                            @elseif($order->status == 'paid' || $order->status == 'processing')
                                <h5 class="text-info font-weight-bold"><i class="fa fa-cog fa-spin mr-2"></i> Diproses</h5>
                            @elseif($order->status == 'completed' || $order->status == 'delivered')
                                <h5 class="text-success font-weight-bold"><i class="fa fa-check-circle mr-2"></i> Selesai</h5>
                            @elseif($order->status == 'cancelled')
                                <h5 class="text-danger font-weight-bold"><i class="fa fa-times-circle mr-2"></i> Dibatalkan</h5>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body">
                        <h6 class="text-muted text-uppercase small font-weight-bold">Status Pembayaran</h6>
                        <div class="mt-2">
                            @if($order->status_online_pay == 'paid')
                                <h5 class="text-success font-weight-bold">LUNAS</h5>
                            @elseif($order->status_online_pay == 'unpaid')
                                <h5 class="text-danger font-weight-bold">BELUM BAYAR</h5>
                            @else
                                <h5 class="text-secondary font-weight-bold">{{ strtoupper($order->status_online_pay) }}</h5>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body">
                        <h6 class="text-muted text-uppercase small font-weight-bold">Metode Pembayaran</h6>
                        <div class="mt-2">
                            <h5 class="text-dark font-weight-bold">
                                <i class="ion-card mr-2"></i> {{ $order->payment_method ?? 'Online Payment' }}
                            </h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="alert alert-info border-info shadow-sm mb-4" role="alert">
            <div class="d-flex align-items-center">
                <div class="mr-3">
                    <i class="ion-ios-information-outline" style="font-size: 30px;"></i>
                </div>
                <div>
                    <h6 class="alert-heading font-weight-bold mb-1">Informasi Pengiriman</h6>
                    <p class="mb-0 small">
                        Kami memasak makanan <strong>Secara Dadakan</strong> saat pesanan masuk. 
                    </p>
                    <p class="mb-0 small">
                        Untuk menjaga kualitas & kehangatan, <strong>Mohon Menunggu</strong> sebentar demi rasa terbaik!
                    </p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8 mb-4">
                <div class="card shadow-sm border-2">
                    <div class="card-header bg-white font-weight-bold py-3">Rincian Menu</div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="border-top-0">Menu</th>
                                        <th class="text-center border-top-0">Qty</th>
                                        <th class="text-right border-top-0">Harga Satuan</th>
                                        <th class="text-right border-top-0">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->orderItems as $item)
                                    <tr>
                                        <td class="align-middle">
                                            <span class="font-weight-bold text-dark">{{ $item->menu_name }}</span>
                                        </td>
                                        <td class="text-center align-middle">x{{ $item->quantity }}</td>
                                        <td class="text-right align-middle">
                                            Rp {{ number_format($item->subtotal / $item->quantity, 0, ',', '.') }}
                                        </td>
                                        <td class="text-right align-middle font-weight-bold text-dark">
                                            Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="bg-light">
                                    <tr>
                                        <td colspan="3" class="text-right font-weight-bold">Subtotal</td>
                                        <td class="text-right">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                                    </tr>
                                    {{-- <tr>
                                        <td colspan="3" class="text-right font-weight-bold">Biaya Layanan (PPN 11%)</td>
                                        <td class="text-right">Berapa ya</td>
                                    </tr> --}}
                                    <tr class="bg-white border-top">
                                        <td colspan="3" class="text-right font-weight-bold text-success h5 mb-0">TOTAL TAGIHAN</td>
                                        <td class="text-right font-weight-bold text-success h5 mb-0">
                                            Rp {{ number_format($order->total_price + $order->delivery_fee, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white font-weight-bold py-3">Tujuan Pengiriman</div>
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-light rounded-circle d-flex justify-content-center align-items-center mr-3" style="width: 40px; height: 40px;">
                                <i class="linearicons-user text-dark font-weight-bold"></i>
                            </div>
                            <div>
                                <h6 class="font-weight-bold mb-0">{{ $order->customer->name }}</h6>
                                <small class="text-muted">Penerima</small>
                            </div>
                        </div>

                        <ul class="list-unstyled mb-0 pl-1">
                            <li class="mb-2 d-flex">
                                <i class="linearicons-phone mr-3 mt-1 text-primary"></i> 
                                <span>{{ $order->customer->phone_number }}</span>
                            </li>
                            <li class="mb-2 d-flex">
                                <i class="linearicons-envelope mr-3 mt-1 text-primary"></i> 
                                <span>{{ $order->customer->email }}</span>
                            </li>
                            <li class="mb-2 d-flex">
                                <i class="linearicons-map-marker mr-3 mt-1 text-primary"></i> 
                                <span>{{ $order->customer->address }}</span>
                            </li>
                        </ul>

                        @if($order->additional_info)
                            <div class="mt-3 p-3 bg-light rounded">
                                <h6 class="font-weight-bold small text-uppercase">Catatan:</h6>
                                <p class="mb-0 small text-muted font-italic">"{{ $order->additional_info }}"</p>
                            </div>
                        @endif
                    </div>
                </div>

                <a href="{{ route('customer.dashboard') }}" class="btn btn-outline-dark btn-block rounded-0">
                    <i class="ion-arrow-left-c mr-2"></i> Kembali ke Dashboard
                </a>
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