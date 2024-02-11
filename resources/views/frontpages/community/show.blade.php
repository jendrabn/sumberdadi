@extends('layouts.front')

@section('title', $community->name)

@section('header')
    <section class="section-pagetop bg">
        <div class="container">
            <div class="row">
                <div class="col-10">
                    <h2 class="title-page">{{$community->name}}</h2>
                    <p>{{Str::limit(strip_tags($community->description), 150)}}</p>
                </div>
                <div class="col-2">
                    <img src="{{$community->logo_url}}" class="img-fluid rounded-circle" style="max-height: 150px" loading="lazy" alt="">
                </div>
            </div>
        </div> <!-- container //  -->
    </section>
@endsection

@section('content')
    <section class="section-content my-5">
        <div class="container">
            <div class="row">
                <main class="col-md-12">
                    <ul class="nav nav-pills mb-4 justify-content-center" id="tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link h5" id="products-tab" data-toggle="tab" href="#products" role="tab" aria-controls="products" aria-selected="true">Produk</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link h5" id="events-tab" data-toggle="tab" href="#events" role="tab" aria-controls="events" aria-selected="false">Acara / Kegiatan</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link h5" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Kontak & Informasi</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade" id="products" role="tabpanel" aria-labelledby="products-tab">
                            <div class="row">
                                @foreach($products as $product)
                                <div class="col-md-3">
                                    <figure class="card card-product-grid">
                                        <div class="img-wrap"> <img src="{{optional($product->images->first())->image_url}}" loading="lazy"> </div>
                                        <figcaption class="info-wrap border-top">
                                            <a href="{{route('product.show', [$product->store->slug, $product->slug])}}" class="title">{{$product->name}}</a>
                                            <div class="price mt-2">@priceIDR($product->price)</div> <!-- price-wrap.// -->
                                        </figcaption>
                                    </figure> <!-- card // -->
                                </div> <!-- col.// -->
                                @endforeach
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    {{$products->appends(request()->input())->links()}}
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="events" role="tabpanel" aria-labelledby="events-tab">
                            @foreach($events as $event)
                            <article class="card card-product-list">
                                <div class="card-body">
                                    <div class="row">
                                        <aside class="col-sm-3">
                                            <a href="#" class="img-wrap"><img src="{{$event->banner_url}}" loading="lazy"></a>
                                        </aside> <!-- col.// -->
                                        <article class="col-sm-6">
                                            <a href="#" class="title mt-2 h5">{{$event->name}}</a>
                                            <div class="rating-wrap mb-3">
                                                <span>Lokasi: <strong>{{$event->location}}</strong></span>

                                            </div>
                                            <p>{{strip_tags($event->description)}}</p>

                                        </article> <!-- col.// -->
                                        <aside class="col-sm-3">
                                            <div class="price-wrap mt-2">
                                                <span class="text-info">
                                                    Dimulai: {{$event->started_at->format('d M Y H:i A')}} @if($event->ended_at) <br> Diakhiri: {{$event->ended_at->format('d M Y H:i A')}} @endif
                                                </span>
                                            </div>
                                            <br>
                                            <p>
                                                <a href="{{route('community.event.show', $event->id)}}" class="btn btn-light"> Lihat <i class="fa fa-external-link"></i>  </a>
                                            </p>
                                            <br>
                                        </aside> <!-- col.// -->
                                    </div> <!-- row.// -->
                                </div> <!-- card-body .// -->
                            </article>
                            @endforeach

                            <div class="row">
                                <div class="col-md-3">
                                    {{$events->appends(request()->input())->links()}}
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                            <div class="card card-info">
                                <div class="card-body">
                                    <h5 class="mb-2">Tentang {{$community->name}} @if($community->founded_at) <small> / Didirikan Pada {{$community->founded_at->format('d M Y')}}</small> @endif</h5>
                                    <p>{{strip_tags($community->description)}}</p>

                                    @if($community->facebook || $community->whatsapp || $community->instagram)
                                        <hr>
                                        <h5 class="mb-2">Social Media</h5>
                                    @endif
                                    @if($community->facebook)
                                        <p>Facebook: <a href="{{$community->facebook}}">{{$community->name}} di Facebook</a></p>
                                    @endif
                                    @if($community->whatsapp)
                                        <p>WhatsApp: <a href="https://wa.me/{{$community->whatsapp}}">{{$community->whatsapp}}</a></p>
                                    @endif
                                    @if($community->instagram)
                                        <p>Instagram: <a href="https://www.instagram.com/{{$community->instagram}}">{{$community->instagram}}</a></p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </section>
@endsection

@push('javascript')
    <script>
        $(function() {
            let hash = window.location.hash;

            if (hash == '' && window.location.search == '') {
                $('a[aria-controls=products]').click();
            }

            $("#tabs").find("li a").each(function(key, val) {
                if (window.location.search.indexOf($(val).attr('href').replace('#', '')) != -1) {
                    $(val).click();
                    return;
                }

                if (hash != -1 && hash == $(val).attr('href')) {
                    $(val).click();
                }
            });
        });
    </script>
@endpush
