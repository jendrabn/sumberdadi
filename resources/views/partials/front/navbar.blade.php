<nav class="navbar navbar-main navbar-expand-lg navbar-light">
    <div class="container">

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main_nav"
                aria-controls="main_nav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="main_nav">
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link pl-0" data-toggle="dropdown" href="#"><strong> <i class="fa fa-bars"></i> &nbsp
                            Menu</strong></a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{route('home')}}">Home</a>
                        <a class="dropdown-item" href="{{route('about_us')}}">Tentang Kami</a>
                        <div class="dropdown-divider"></div>
                        @foreach(\App\Models\ProductCategory::all() as $category)
                            <a href="{{route('products', ['category' => $category->id])}}" class="dropdown-item">{{$category->name}}</a>
                        @endforeach
                    </div>
                </li>
                <li class="nav-item">
                    <a href="{{route('products')}}" class="nav-link"> Semua Produk</a>
                </li>
                @foreach(\App\Models\ProductCategory::take(5)->get() as $category)
                    <li class="nav-item">
                        <a href="{{route('products', ['category' => $category->id])}}" class="nav-link">{{ $category->name }}</a>
                    </li>
                @endforeach
            </ul>
        </div> <!-- collapse .// -->
    </div> <!-- container .// -->
</nav>
