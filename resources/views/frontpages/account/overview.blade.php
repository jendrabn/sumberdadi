@extends('layouts.front')

@section('title', 'Account Detail')

@section('header')
    <section class="section-pagetop bg">
        <div class="container">
            <h2 class="title-page">Account Overview</h2>
        </div> <!-- container //  -->
    </section>
@endsection

@section('content')
    <section class="section-content padding-y-lg">
        <div class="container">
            <div class="row">
                @include('partials.front.sidebar')
                <main class="col-md-9">
                    <article class="card mb-3">
                        <div class="card-body">

                            <figure class="icontext">
                                <span class="icon icon-lg rounded-circle bg-primary">
                                    <i class="fa fa-user white"></i>
                                </span>
                                <div class="text">
                                    <strong> {{ $user->full_name }} </strong> <br>
                                    <p class="pt-4">{{ $user->email }}</p>
                                </div>
                            </figure>
                            <hr>
                            @if ($user->addresses->isNotEmpty())
                            <p>
                                <i class="fa fa-map-marker text-muted"></i> Alamat Saya:
                                @php $address = $user->addresses()->first(); @endphp
                                {{$address->address}}, {{$address->city->name}}, {{$address->province->name}}, {{$address->phone}}
                            </p>
                            @endif

                            <article class="card-group">
                                <figure class="card bg">
                                    <div class="p-3">
                                        <h5 class="card-title">{{$user->orders->count()}}</h5>
                                        <span>Pesanan</span>
                                    </div>
                                </figure>
                                <figure class="card bg">
                                    <div class="p-3">
                                        <h5 class="card-title">{{$user->communities->count()}}</h5>
                                        <span>Komunitas</span>
                                    </div>
                                </figure>
                            </article>


                        </div> <!-- card-body .// -->
                    </article> <!-- card.// -->

                    @if ($user->orders->isNotEmpty())
                    <article class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title mb-4">Riwayat Pesanan</h5>

                            <div class="row">
                                @foreach ($user->orders->sortByDesc('created_at') as $order)
                                <div class="col-md-6">
                                    <figure class="itemside mb-3">
                                        @php $item = $order->items()->first(); @endphp;
                                        <div class="aside"><img src="{{optional($item->product->images()->first())->image_url}}" class="border img-sm"></div>
                                        <figcaption class="info">
                                            <time class="text-muted"><i class="fa fa-calendar-alt"></i> {{$order->created_at->format('d F Y H:i A')}}</time>
                                            <p><a href="{{route('user.orders')}}">Pesanan #{{$order->id}}</a></p>
                                            <span class="text-warning">Status: {{$order->status}}</span>
                                        </figcaption>
                                    </figure>
                                </div> <!-- col.// -->
                                @endforeach
                            </div> <!-- row.// -->

                            <a href="{{route('user.orders')}}" class="btn btn-outline-primary"> See all orders  </a>
                        </div> <!-- card-body .// -->
                    </article> <!-- card.// -->
                    @endif

                </main>
            </div>
        </div>
    </section>
@endsection
