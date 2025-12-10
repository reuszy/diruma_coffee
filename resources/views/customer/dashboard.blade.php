@extends('layouts.main-site')

@section('title', 'Dashboard Pesanan')

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

<div class="breadcrumb_section background_bg overlay_bg_50 page_title_light" data-img-src="/assets/images/checkout_bg.jpg">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title">
                    <h1>Dashboard</h1>
                </div>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active">Pesanan Saya</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                
                <div class="card shadow-sm border-0" style="border-radius: 8px;">
                    
                    <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 text-dark font-weight-bold">Riwayat Pesanan</h5>
                        <span class="badge bg-secondary text-white">{{ $orders->total() }} Orders</span>
                    </div>
                    
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped mb-0" style="border-color: #ebedf2;">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="py-3 text-dark font-weight-bold" style="background-color: #f8f9fa;">Order ID</th>
                                        <th class="py-3 text-dark font-weight-bold" style="background-color: #f8f9fa;">Tanggal</th>
                                        <th class="py-3 text-dark font-weight-bold" style="background-color: #f8f9fa;">Total Harga</th>
                                        
                                        <th class="py-3 text-dark font-weight-bold" style="background-color: #f8f9fa;">Status Pesanan</th>
                                        
                                        <th class="py-3 text-dark font-weight-bold" style="background-color: #f8f9fa;">Status Pembayaran</th>
                                        <th class="py-3 text-dark font-weight-bold" style="background-color: #f8f9fa;">Tipe Order</th>
                                        <th class="py-3 text-dark font-weight-bold text-center" style="background-color: #f8f9fa;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($orders as $order)
                                    <tr>
                                        <td class="align-middle text-primary font-weight-bold">
                                            #{{ $order->order_no }}
                                        </td>
                                        
                                        <td class="align-middle text-muted">
                                            {{ $order->created_at->format('d M Y, H:i') }}
                                        </td>
                                        
                                        <td class="align-middle">
                                            Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                        </td>

                                        <td class="align-middle">
                                            @if($order->status == 'completed')
                                                <span class="badge bg-success text-white px-3 py-2" style="font-size: 12px;">
                                                    <i class="fa fa-check"></i> Pesanan Selesai
                                                </span>
                                            @elseif($order->status == 'delivered')
                                                <span class="badge bg-info text-white px-3 py-2" style="font-size: 12px;">
                                                    <i class="fa fa-truck"></i> Sedang Diantar
                                                </span>
                                            @elseif($order->status == 'pending')
                                                <span class="badge bg-warning text-white px-3 py-2" style="font-size: 12px;">
                                                    <i class="fa fa-clock"></i> Pesanan Dibuat
                                                </span>
                                            @else
                                                <span class="badge bg-secondary text-white px-3 py-2" style="font-size: 12px;">
                                                    {{ $order->status }}
                                                </span>
                                            @endif
                                        </td>
                                        
                                        <td class="align-middle">
                                            @if($order->status_online_pay == 'paid')
                                                <span class="badge bg-success text-white px-3 py-2" style="font-size: 12px;">
                                                    <i class="fa fa-check"></i> Lunas
                                                </span>
                                            @elseif($order->status == 'cancelled' || $order->status == 'Dibatalkan')
                                                <span class="badge bg-danger text-white px-3 py-2" style="font-size: 12px;">Cancelled</span>
                                            @else
                                                <span class="badge bg-danger text-white px-3 py-2" style="font-size: 12px;">
                                                    <i class="fa fa-exclamation-circle"></i> Belum Bayar
                                                </span>
                                            @endif
                                        </td>
                                        
                                        <td class="align-middle text-muted">
                                            {{ ucfirst($order->order_type) }}
                                        </td>
                                        
                                        <td class="align-middle text-center">
                                            @if($order->status_online_pay == 'unpaid' && $order->status != 'cancelled' && $order->status != 'Dibatalkan')
                                                <form action="{{ route('payment.repay', $order->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    <button type="submit" class="btn btn-warning btn-sm text-white" title="Bayar Sekarang">
                                                        <i class="fa fa-credit-card"></i> Bayar
                                                    </button>
                                                </form>
                                            {{-- @else
                                                <a href="#" class="btn btn-primary btn-sm" title="Lihat Detail">
                                                    <i class="fa fa-eye"></i> Detail --}}
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-5">
                                            <div class="mb-3 text-muted">
                                                <i class="ti-shopping-cart-full" style="font-size: 3rem; opacity: 0.3;"></i>
                                            </div>
                                            <p class="text-muted mb-3">Belum ada riwayat pesanan.</p>
                                            <a href="{{ route('catering') }}" class="btn btn-primary btn-sm">Belanja Sekarang</a>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <div class="card-footer bg-white border-top-0 py-3">
                        <div class="d-flex justify-content-end">
                            {{ $orders->links() }}
                        </div>
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