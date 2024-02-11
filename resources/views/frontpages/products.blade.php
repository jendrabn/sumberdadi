@extends('layouts.front')

@section('title', 'Semua Produk')

@section('header')
    <section class="section-pagetop bg">
        <div class="container">
            <h2 class="title-page">{{$header ?? 'Semua Produk'}}</h2>
            <nav>
                <ol class="breadcrumb text-white">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                    <li class="breadcrumb-item {{request()->has('category') ? '' : 'active'}}" aria-current="page"><a href="{{url('products')}}">Semua Produk</a></li>
                    @if (request()->has('category') && !empty($category))
                        <li class="breadcrumb-item active"><a href="{{route('products', ['category' => request()->get('category')])}}">{{$category->name}}</a></li>
                    @endif
                </ol>
            </nav>
        </div> <!-- container //  -->
    </section>
@endsection

@section('content')
    <section class="section-content padding-y">
        <div class="container">

            <div class="row">
                <aside class="col-md-3">

                    <div class="card">
                        <article class="filter-group">
                            <header class="card-header">
                                <a href="#" data-toggle="collapse" data-target="#collapse_1" aria-expanded="true" class="">
                                    <i class="icon-control fa fa-chevron-down"></i>
                                    <h6 class="title">Product category</h6>
                                </a>
                            </header>
                            <div class="filter-content collapse show" id="collapse_1" style="">
                                <div class="card-body">

                                    <ul class="list-menu">
                                        {{-- @TODO: move to the view composers--}}
                                        @foreach(\App\Models\ProductCategory::all() as $category)
                                        <li><a class="{{request()->get('category') == $category->id ? 'text-primary' : ''}}" href="{{route('products', ['category' => $category->id])}}">{{$category->name}}  </a></li>
                                        @endforeach
                                    </ul>

                                </div> <!-- card-body.// -->
                            </div>
                        </article> <!-- filter-group  .// -->
                        <article class="filter-group">
                            <header class="card-header">
                                <a href="#" data-toggle="collapse" data-target="#collapse_3" aria-expanded="true" class="">
                                    <i class="icon-control fa fa-chevron-down"></i>
                                    <h6 class="title">Price range </h6>
                                </a>
                            </header>
                            <div class="filter-content collapse show" id="collapse_3" style="">
                                <div class="card-body">
                                    <form method="GET" action="{{url()->current()}}">
                                        @if (request()->has('category'))
                                        <input type="hidden" name="category" value="{{request()->get('category')}}">
                                        @endif
{{--                                    <input type="range" class="custom-range" min="{{$products->min('price')}}" max="{{$products->max('price')}}">--}}
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label>Min</label>
                                            <input class="form-control" placeholder="Rp 0" value="{{request()->get('price_min')}}" name="price_min" type="number">
                                        </div>
                                        <div class="form-group text-right col-md-6">
                                            <label>Max</label>
                                            <input class="form-control" placeholder="Rp. 1.0000,-" value="{{request()->get('price_max')}}" name="price_max" type="number">
                                        </div>
                                    </div> <!-- form-row.// -->
                                    <button type="submit" class="btn btn-block btn-primary">Apply</button>
                                    </form>
                                </div><!-- card-body.// -->
                            </div>
                        </article> <!-- filter-group .// -->
                        <article class="filter-group">
                            <header class="card-header">
                                <a href="#" data-toggle="collapse" data-target="#collapse_5" aria-expanded="true" class="">
                                    <i class="icon-control fa fa-chevron-down"></i>
                                    <h6 class="title">Rating </h6>
                                </a>
                            </header>
                            <div class="filter-content in collapse show" id="collapse_5" style="">
                                <div class="card-body">
                                    <form action="{{url()->current()}}">
                                    <label class="custom-control custom-radio">
                                        <input type="radio" name="rating" checked="" value="5" class="custom-control-input">
                                        <div class="custom-control-label">Sangat Baik </div>
                                    </label>

                                    <label class="custom-control custom-radio">
                                        <input type="radio" name="rating" value="4" class="custom-control-input">
                                        <div class="custom-control-label">Baik </div>
                                    </label>

                                    <label class="custom-control custom-radio">
                                        <input type="radio" name="rating" value="3" class="custom-control-input">
                                        <div class="custom-control-label">Menengah </div>
                                    </label>

                                    <label class="custom-control custom-radio">
                                        <input type="radio" name="rating" value="2" class="custom-control-input">
                                        <div class="custom-control-label">Buruk</div>
                                    </label>

                                    <label class="custom-control custom-radio">
                                        <input type="radio" name="rating" value="1" class="custom-control-input">
                                        <div class="custom-control-label">Sangat Buruk</div>
                                    </label>
                                    <button type="submit" class="btn btn-block btn-primary mt-2">Apply</button>
                                    </form>
                                </div><!-- card-body.// -->
                            </div>
                        </article> <!-- filter-group .// -->
                    </div> <!-- card.// -->

                </aside> <!-- col.// -->
                <main class="col-md-9">

                    <div class="row">
                        @foreach ($products as $product)
                        <div class="col-md-4">
                            <figure class="card card-product-grid">
                                <div class="img-wrap">
                                    <img src="{{optional($product->images->first())->image_url}}">
                                    <a class="btn-overlay" href="{{route('product.show', [$product->store->slug, $product->slug])}}"><i class="fa fa-search-plus"></i> View Detail</a>
                                </div> <!-- img-wrap.// -->
                                <figcaption class="info-wrap">
                                    <div class="fix-height">
                                        <a href="{{route('product.show', [$product->store->slug, $product->slug])}}" class="title">{{$product->name}}</a>
                                        <small class="text-muted">Toko: {{$product->store->name}}</small>
                                        <div class="price-wrap mt-1">
                                            <span class="price">@priceIDR($product->price)</span>
                                        </div> <!-- price-wrap.// -->
                                    </div>
                                    <a href="{{route('cart', ['product' => $product->id, 'quantity' => 1])}}" class="btn btn-block btn-primary">Add to cart </a>
                                </figcaption>
                            </figure>
                        </div> <!-- col.// -->
                        @endforeach

                    </div> <!-- row end.// -->


                    <nav class="mt-4" aria-label="Product navigation">
                        {{$products->appends(request()->input())->links()}}
                    </nav>

                </main> <!-- col.// -->

            </div>

        </div> <!-- container .//  -->
    </section>
@endsection
