<header class="section-header">
@php
$dashboardRoute = route('user.overview');
if (auth()->user()) {
    $role = auth()->user()->role;
    if ($role === 'admin') {
        $dashboardRoute = route('admin.dashboard');
    } elseif ($role === 'seller') {
        $dashboardRoute = route('seller.dashboard');
    }
}
@endphp
    <section class="header-main border-bottom">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-2 col-sm-4">
                    <a href="{{ url('/') }}" class="brand-wrap">
                        <img class="logo" src="{{ asset('images/J-Coffee.png') }}">
                        <span class="text-strong text-dark h5 mb-0">J.Coffee</span>
                    </a> <!-- brand-wrap.// -->
                </div>
                <div class="col-lg-6 col-sm-12">
                    <form action="{{route('products')}}" class="search">
                        <div class="input-group w-100">
                            <input type="text" name="q" class="form-control" placeholder="Search">
                            <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">
                                <i class="fa fa-search"></i> Search
                            </button>
                            </div>
                        </div>
                    </form> <!-- search-wrap .end// -->
                </div> <!-- col.// -->
                <div class="col-lg-4 col-sm-6 col-12">
                    <div class="widgets-wrap float-md-right">
                        <div class="widget-header  mr-3">
                            <a href="{{route('cart')}}" class="icon icon-sm rounded-circle border"><i class="fa fa-shopping-cart"></i></a>
                        </div>
                        <div class="widget-header icontext">
                            <a href="{{ $dashboardRoute }}" class="icon icon-sm rounded-circle border"><i class="fa fa-home"></i></a>
                            <div class="text">
                                <span class="text-muted">Welcome!</span>
                                <div>
                                @if (auth()->guest())
                                    <a href="{{ route('login') }}">Sign in</a> |
                                    <a href="{{ route('register') }}"> Register</a>
                                @else
                                    {{ auth()->user()->full_name }}
                                @endif
                                </div>
                            </div>
                        </div>

                    </div> <!-- widgets-wrap.// -->
                </div> <!-- col.// -->
            </div> <!-- row.// -->
        </div> <!-- container.// -->
    </section> <!-- header-main .// -->

    @include('partials.front.navbar')
</header> <!-- section-header.// -->
