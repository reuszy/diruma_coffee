<nav class="navbar navbar-expand-lg"> 
    <a class="navbar-brand" href="{{ route('home') }}">
        <img class="logo_light" src="/assets/images/logo_diruma_putih.png" alt="logo">
        <img class="logo_dark" src="/assets/images/logo_diruma_putih.png" alt="logo">
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-expanded="false"> 
        <span class="ion-android-menu"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
        <ul class="navbar-nav">
            <li>  <a href="{{ route('home') }}" class="nav-link {{ Request::routeIs('home') ? 'active' : '' }}">Home</a> </li>
            <li>  <a href="{{ route('menu') }}" class="nav-link {{ Request::is('menu*') ? 'active' : '' }}">Menu</a> </li>
            <li>  <a href="{{ route('blogs') }}" class="nav-link {{ Request::is('blog*') ? 'active' : '' }}">Jadwal</a> </li>
            <li>  <a href="{{ route('about') }}" class="nav-link {{ Request::routeIs('about') ? 'active' : '' }}">Tentang</a> </li>
            <li> <a href="{{ route('contact') }}" class="nav-link {{ Request::routeIs('contact') ? 'active' : '' }}">Kontak</a> </li>

        </ul>
        
    </div>

    <ul class="navbar-nav attr-nav align-items-center">
        <li>
            <a class="nav-link account_trigger" href="#"><i class="linearicons-user"></i></a>
        </li>

        @auth
            @if (Auth::user()->role === 'customer')
                <li>
                    <a class="nav-link {{ Request::routeIs('cart') ? 'active' : '' }}" href="{{ route('customer.cart') }}">
                        <i class="linearicons-cart"></i>
                        <span class="cart_count" id="cart_count">{{ $customer_total_cart_items }}</span>
                    </a>
                </li>
            @endif
        @endauth

    </ul>
    
    {{-- <div class="header_btn ml-1 ml-md-2"> 
        <a href="{{ route('catering') }}" class="btn btn-success rounded-0 btn-sm px-2">
            <i class="fas fa-utensils d-none d-sm-inline mr-1"></i>
            KATERING
        </a>
    </div> --}}

    <div class="header_btn ml-1 ml-md-2 {{ Auth::check() ? 'd-none d-lg-block' : '' }}">
    <a href="{{ route('catering') }}" class="btn btn-success rounded-0 btn-sm px-2">
        <i class="fas fa-utensils d-none d-sm-inline mr-1"></i>
        KATERING
    </a>
</div>

</nav>
