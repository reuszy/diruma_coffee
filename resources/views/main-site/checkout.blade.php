@extends('layouts.main-site')

@section('title', 'Bayar Pesanan')

@push('styles')
    <link rel="stylesheet" href="/assets/css/animate.css">  
    <link rel="stylesheet" href="/assets/bootstrap/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Kaushan+Script&amp;display=swap" rel="stylesheet"> 
    <link href="https://fonts.googleapis.com/css?family=Josefin+Sans:100,100i,300,300i,400,400i,600,600i,700,700i&amp;display=swap" rel="stylesheet"> 
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i&amp;display=swap" rel="stylesheet"> 
    <link rel="stylesheet" href="/assets/css/all.min.css">
    <link rel="stylesheet" href="/assets/css/ionicons.min.css">
    <link rel="stylesheet" href="/assets/css/themify-icons.css">
    <link rel="stylesheet" href="/assets/css/linearicons.css">
    <link rel="stylesheet" href="/assets/css/flaticon.css">
    <link rel="stylesheet" href="/assets/owlcarousel/css/owl.carousel.min.css">
    <link rel="stylesheet" href="/assets/owlcarousel/css/owl.theme.css">
    <link rel="stylesheet" href="/assets/owlcarousel/css/owl.theme.default.min.css">
    <link rel="stylesheet" href="/assets/css/slick.css">
    <link rel="stylesheet" href="/assets/css/slick-theme.css">
    <link rel="stylesheet" href="/assets/css/magnific-popup.css">
    <link href="/assets/css/datepicker.min.css" rel="stylesheet">
    <link href="/assets/css/mdtimepicker.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/css/responsive.css">
    <link id="layoutstyle" rel="stylesheet" href="/assets/color/theme-red.css">
@endpush

@push('scripts')
 
    <script src="/assets/js/jquery-1.12.4.min.js"></script> 
    <script src="/assets/bootstrap/js/bootstrap.min.js"></script> 
    <script src="/assets/owlcarousel/js/owl.carousel.min.js"></script> 
    <script src="/assets/js/magnific-popup.min.js"></script> 
    <script src="/assets/js/waypoints.min.js"></script> 
    <script src="/assets/js/parallax.js"></script> 
    <script src="/assets/js/jquery.countdown.min.js"></script> 
    <script src="/assets/js/jquery.countTo.js"></script>
    <script src="/assets/js/imagesloaded.pkgd.min.js"></script>
    <script src="/assets/js/isotope.min.js"></script>
    <script src="/assets/js/jquery.appear.js"></script>
    <script src="/assets/js/jquery.dd.min.js"></script>
    <script src="/assets/js/slick.min.js"></script>
    <script src="/assets/js/datepicker.min.js"></script>
    <script src="/assets/js/mdtimepicker.min.js"></script>
    <script src="/assets/js/scripts.js"></script>

    @isset($snapToken)
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>

    <script type="text/javascript">
      var payButton = document.getElementById('pay-button');
      if(payButton) {
          payButton.onclick = function(){
            // SnapToken dari Controller
            snap.pay('{{ $snapToken }}', {
              onSuccess: function(result){
                window.location.href = "{{ route('customer.dashboard') }}";
              },
              onPending: function(result){
                /* Ganti URL ini */
                window.location.href = "{{ route('customer.dashboard') }}";
                alert("Menunggu Pembayaran...");
              },
              onError: function(result){
                location.reload();
              }
            });
          };
      }
    </script>
    @endisset

@endpush


@section('title', 'Checkout')


@section('header')
    <header class="header_wrap fixed-top header_with_topbar light_skin main_menu_uppercase">
        <div class="container">
            @include('partials.nav')
        </div>
    </header>
    @endsection


@section('content')

<div class="breadcrumb_section background_bg overlay_bg_50 page_title_light" data-img-src="/assets/images/menu_diruma.jpg">
    <div class="container"><div class="row">
            <div class="col-sm-12">
                <div class="page-title">
                    <h1>Checkout</h1>
                </div>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active">Checkout</li>
                </ol>
            </div>
        </div>
    </div>
</div>

@isset($snapToken)
    <div class="section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 text-center">
                    <div class="alert alert-success">
                        <h4>Order Berhasil Dibuat!</h4>
                        <p>Order ID: {{ $order->order_no ?? '-' }}</p>
                        <p>Total: {!! $site_settings->currency_symbol ?? 'Rp' !!}{{ number_format($subtotal, 2) }}</p>
                    </div>
                    
                    <button type="button" class="btn btn-default btn-block btn-lg" id="pay-button">
                        BAYAR SEKARANG
                    </button>
                    
                    <br><br>

                    <a href="{{ route('customer.cart') }}" class="btn btn-danger ">Kembali</a>

                </div>
            </div>
        </div>
    </div>

@else
    <form method="post" action="{{ route('payment') }}">
    @csrf
    <div class="section">
        <div class="container">
            @include('partials.message-bag')
        
            <div class="row">
                <div class="col-lg-6">
                    <div class="heading_s1">
                        <h4>Formulir Pesanan</h4>
                    </div>
                    <div class="row">

                        <div class="form-group col-md-12">
                            <input class="form-control" required type="text" name="name" value="{{ old('name', auth()->user()->first_name ?? '') }}" placeholder="Nama *">
                        </div>

                        <div class="form-group col-md-12">
                            <input class="form-control" required type="email" name="email" value="{{ old('email', auth()->user()->email ?? '') }}" placeholder="Email *">
                        </div>

                        <div class="form-group col-md-12">
                            <input class="form-control" required type="tel" name="phone_number" value="{{ old('phone_number', auth()->user()->phone_number ?? '') }}" placeholder="Nomor Telepon *">
                        </div>

                        <div class="form-group col-md-12">
                            <input class="form-control" required type="text" name="address" value="{{ old('address') }}" placeholder="Alamat *">
                        </div>

                        <div class="form-group col-md-6">
                            <input class="form-control" required type="text" name="city" value="{{ old('city') }}" placeholder="Kota *">
                        </div>

                        <div class="form-group col-md-6">
                            <input class="form-control" required type="text" name="state" value="Indonesia" placeholder="Negara *" readonly>
                        </div>

                        <div class="form-group col-md-6">
                            <input class="form-control" type="text" name="county" value="{{ old('county') }}" placeholder="Provinsi (Opsional)">
                        </div>

                        <div class="form-group col-md-6">
                            <input class="form-control" required type="text" name="postcode" value="{{ old('postcode') }}" placeholder="Kode POS *">
                        </div>

                        <div class="form-group mb-0 mt-2 col-md-12">
                            <div class="heading_s1">
                                <h4>Informasi Tambahan</h4>
                            </div>
                            <textarea rows="4" class="form-control" name="additional_info" placeholder="Alergi Kacang, Tidak Pakai Sambal, dll">{{ old('additional_info') }}</textarea>
                        </div> 
                    </div>
                
                </div>
                <div class="col-lg-6">
                    <div class="order_review">
                        <div class="heading_s1">
                            <h4>Pesanan Anda</h4>
                        </div>
                        <div class="table-responsive order_table">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Produk</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($cart as $item)
                                    <tr>
                                        <td>{{ $item['name'] }} <span class="product-qty">x {{ $item['quantity'] }}</span></td>
                                        <td>{!! $site_settings->currency_symbol ?? 'Rp' !!}{{ number_format($item['price'] * $item['quantity'], 2) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Subtotal Pesanan</th>
                                        <td class="product-subtotal">{!! $site_settings->currency_symbol ?? 'Rp' !!}{{ number_format($subtotal, 2) }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="payment_method">
                            <div class="heading_s1">
                                <h4>Metode Pembayaran</h4>
                            </div>
                            <div class="payment_option">
                                <div class="custome-radio">
                                    <input class="form-check-input" type="radio" name="payment_option" id="exampleRadios5" value="option5" checked="">
                                    <label class="form-check-label" for="exampleRadios5">Transfer / QRIS</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 text-start">
                                <button onclick="window.location.href='{{ route('customer.cart') }}'" type="button" class="btn btn-secondary btn-block">Kembali</button>
                            </div>
                            <div class="col-6 text-end">
                                <button type="submit" class="btn btn-default btn-block">Buat Pesanan</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    </form>
@endisset

@endsection