@extends('layouts.front')

@section('title', 'My Orders')

@section('header')
    <section class="section-pagetop bg">
        <div class="container">
            <h2 class="title-page">My orders</h2>
        </div> <!-- container //  -->
    </section>
@endsection

@section('content')
    <section class="section-content padding-y-lg">
        <div class="container">
            <div class="row">
                @include('partials.front.sidebar')
                <main class="col-md-9">
                    <article class="card">
                        <header class="card-header">
                            <strong class="d-inline-block mr-3">Daftar Pesanan</strong>
                            <span></span>
                        </header>

                        @if ($orders->isNotEmpty())
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Items</th>
                                        <th>Total Amount</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($orders as $order)
                                <tr>
                                    <td>{{$order->id}}</td>
                                    <td>{{$order->items->count()}}</td>
                                    <td>@priceIDR($order->total_amount)</td>
                                    <td>{{$order->status}}</td>
                                    <td>{{ $order->created_at }}</td>
                                    <td width="250">
                                        <a href="{{route('user.orders.show', $order->id)}}" class="btn btn-light"> Detail <i class="fa fa-eye"></i> </a>
                                    </td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div> <!-- table-responsive .end// -->
                        @else
                            <p class="mx-2 my-2">Anda belum memiliki pesanan, yuk pesan sekarang!</p>
                        @endif
                    </article> <!-- order-group.// -->
                </main>
            </div>
        </div>
    </section>
@endsection
