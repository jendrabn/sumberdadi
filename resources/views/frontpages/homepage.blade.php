@extends('layouts.front')

@section('title', 'Home')

@section('content')

    <!-- ========================= SECTION INTRO ========================= -->
    <section class="section-intro padding-y-sm">
        <div class="container">

            <div class="intro-banner-wrap" style="height: 300px; overflow: hidden;">
                <img src="{{ asset('images/banners/1.jpg') }}" class="img-fluid rounded w-100 h-100" style="object-fit: cover">
            </div>

        </div> <!-- container //  -->
    </section>
    <!-- ========================= SECTION INTRO END// ========================= -->


    <!-- ========================= SECTION FEATURE ========================= -->
    <section class="section-content padding-y-sm">
        <div class="container">
            <article class="card card-body">
                <div class="row">
                    <div class="col-md-4">
                        <figure class="item-feature">
                            <span class="text-primary"><i class="fa fa-2x fa-truck"></i></span>
                            <figcaption class="pt-3">
                                <h5 class="title">Pengiriman Produk Cepat</h5>
                                <p>Pengiriman produk antar kota di Indonesia sangatlah cepat</p>
                            </figcaption>
                        </figure> <!-- iconbox // -->
                    </div><!-- col // -->
                    <div class="col-md-4">
                        <figure  class="item-feature">
                            <span class="text-primary"><i class="fa fa-2x fa-landmark"></i></span>
                            <figcaption class="pt-3">
                                <h5 class="title">Kualitas Terjaga</h5>
                                <p>Kualitas biji kopi langsung diambil dari komunitas-komunitas pencinta di Indonesia.</p>
                            </figcaption>
                        </figure> <!-- iconbox // -->
                    </div><!-- col // -->
                    <div class="col-md-4">
                        <figure  class="item-feature">
                            <span class="text-primary"><i class="fa fa-2x fa-lock"></i></span>
                            <figcaption class="pt-3">
                                <h5 class="title">Pembayaran Aman </h5>
                                <p>Transaksi pada J.Coffee sangatlah aman dan cepat</p>
                            </figcaption>
                        </figure> <!-- iconbox // -->
                    </div> <!-- col // -->
                </div>
            </article>

        </div> <!-- container .//  -->
    </section>
    <!-- ========================= SECTION FEATURE END// ========================= -->

    <!-- ========================= SECTION CONTENT ========================= -->
    <section class="section-content">
        <div class="container">

            <header class="section-heading">
                <h3 class="section-title">Produk Terbaru</h3>
            </header><!-- sect-heading -->

            <div class="row">
                @foreach($latest_products as $product)
                <div class="col-md-3">
                    <div class="card card-product-grid">
                        <a href="{{ route('product.show', [$product->store, $product]) }}" class="img-wrap"> @if($product->images->isNotEmpty()) <img src="{{ $product->images->first()->image_url }}" loading="lazy"> @endif </a>
                        <figcaption class="info-wrap">
                            <a href="{{ route('product.show', [$product->store, $product]) }}" class="title">{{ $product->name }}</a>
                            @if ($product->ratings->isNotEmpty())
                            <div class="rating-wrap">
                                <ul class="rating-stars">
                                    <li class="stars-active">
                                        {!! str_repeat('<i class="fa fa-star"></i>', $product->rating_avg) !!}
                                    </li>
                                    <li>
                                        {!! str_repeat('<i class="fa fa-star"></i>', $product->rating_avg) !!}
                                    </li>
                                </ul>
                                <span class="label-rating text-muted"> {{ $product->ratings->count() }} reviews</span>
                            </div>
                            @endif
                            <div class="price mt-1">@priceIDR($product->price)</div> <!-- price-wrap.// -->
                        </figcaption>
                    </div>
                </div> <!-- col.// -->
                @endforeach
            </div> <!-- row.// -->

        </div> <!-- container .//  -->
    </section>
    <!-- ========================= SECTION CONTENT END// ========================= -->

    <!-- ========================= SECTION CONTENT ========================= -->
    <section class="section-content mb-3">
        <div class="container">

            <header class="section-heading">
                <h3 class="section-title">Event Terbaru</h3>
            </header><!-- sect-heading -->

            <div class="row">
                @foreach($latest_events as $event)
                    <div class="col-md-3">
                        <div class="card card-product-grid">
                            <a href="{{ route('community.event.show', $event->id) }}" class="img-wrap"> <img src="{{ $event->banner_url }}" loading="lazy"> </a>
                            <figcaption class="info-wrap">
                                <a href="{{ route('community.event.show', $event->id) }}" class="title">{{ $event->name }}</a>
                                <div class="price mt-1">{{$event->location}}</div> <!-- price-wrap.// -->
                            </figcaption>
                        </div>
                    </div> <!-- col.// -->
                @endforeach
            </div> <!-- row.// -->

        </div> <!-- container .//  -->
    </section>
    <!-- ========================= SECTION CONTENT END// ========================= -->
@endsection
