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

@endpush

@section('content')
<div class="breadcrumb_section background_bg overlay_bg_50 page_title_light" data-img-src="/assets/images/checkout_bg.jpg">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title">
                    <h1>Selesaikan Pembayaran</h1>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="section payment-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-5">
                <div class="order_review">
                    <div class="heading_s1">
                        <h4>Ringkasan Pesanan</h4>
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
                                    <td>Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Total Bayar</th>
                                    <td class="product-subtotal"><strong>Rp {{ number_format($subtotal, 0, ',', '.') }}</strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="mt-4">
                        <p class="text-muted small">* Silakan pilih metode pembayaran di sebelah kanan.</p>
                        <a href="{{ route('home') }}" class="btn btn-secondary btn-sm">Batal / Kembali</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-7">
                <div class="heading_s1">
                    <h4>Pilih Metode Pembayaran</h4>
                </div>
                
                <div id="snap-container"></div>
                
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>

    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function(event) { 
            var snapToken = '{{ $snapToken }}';
            
            if(snapToken) {
                snap.embed(snapToken, {
                    embedId: 'snap-container',
                    onSuccess: function (result) {
                        window.location.href = "{{ route('customer.dashboard') }}";
                    }, 
                    onPending: function (result) {
                        alert("Menunggu Pembayaran...");
                        window.location.href = "{{ route('customer.dashboard') }}";
                    },
                    onError: function (result) {
                        alert("Pembayaran Gagal!");
                        location.reload();
                    }
                });
            }
        });
    </script>
@endpush