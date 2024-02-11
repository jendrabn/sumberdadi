@extends('layouts.front')

@section('title', 'Checkout Berhasil')

@section('header')
    <section class="section-pagetop bg">
        <div class="container">
            <h2 class="title-page">Checkout Berhasil</h2>
        </div> <!-- container //  -->
    </section>
@endsection

@section('content')
    <section class="section-content my-5">
        <div class="container">
            <div class="row">
                <main class="col-md-12">
                    <div class="card card-success">
                        <div class="card-body">
                            <h4 class="h-5 mb-4">Terima kasih telah berbelanja di {{config('app.name')}}</h4>
                            <p>Checkout teah berhasil! Silahkan melihat daftar pesanan pada menu <a href="{{route('user.orders')}}">Daftar Pesanan</a>.</p>
                            <p>Setiap produk yang anda pesan dapat membantu UKM dan Komunitas untuk terus berkembang.</p>

                        </div>
                    </div> <!-- card.// -->

                </main> <!-- col.// -->
            </div>

        </div> <!-- container .//  -->
    </section>
@endsection
