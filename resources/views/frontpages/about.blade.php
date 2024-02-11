@extends('layouts.front')

@section('title', 'Tentang Kami')

@section('header')
    <section class="section-pagetop bg">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2 class="title-page">Tentang Kami</h2>
                </div>
            </div>
        </div> <!-- container //  -->
    </section>
@endsection

@section('content')
    <section class="section-content my-5">
        <div class="container">
            <div class="row">
                <main class="col-lg-12">
                    <p>{{config('app.name')}} sebagai media pemasaran dan penjualan komunitas budidaya kopi Jember serta marketplace yang dibuat khusus untuk produk hasil dari Komunitas/UKM lokal.</p>
                    <p>Tujuan dibangunnya {{config('app.name')}} adalah:</p>
                    <ul>
                        <li>Membantu memasarkan kopi khas Jember hasil budidaya komunitas kepada khayalak luar.</li>
                        <li>Membantu masyarakan pencinta kopi untuk mendapatkan kopi yang terjamin asli dan dari tangan pertama.</li>
                        <li>Membantu memperluas lingkup penjualan dan pemasaran produk kopi dari komunitas budidaya kopi di Jember.</li>
                        <li>Membantu menyediakan tempat bagi komunitas budidaya kopi untuk memasarkan kopi Jember secara khusus.</li>
                    </ul>
                    <p>Keuntungan yang diperoleh dari {{config('app.name')}}</p>
                    <ul>
                        <li>Mempermudah masyarakat mendapatkan informasi para komunitas/UKM kopi di Jember.</li>
                        <li>Mempermudah customer mendapatkan kopi dari tangan pertama.</li>
                        <li>Mempermudah bagi pihak komunitas/UKM untuk menjual dan memasarkan produknya.</li>
                    </ul>
                </main>
            </div>
        </div>
    </section>
@endsection
