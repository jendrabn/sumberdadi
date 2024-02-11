@extends('layouts.app')

@section('title', $store->name)

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Toko: {{$store->name}}</h1>
        </div>
        <div class="row">
            <div class="col-8">
                <div class="card card-primary">
                    <div class="card-header">
                        <h4>Detail Toko: {{$store->name}}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row my-2">
                            <div class="col-md-4">
                                <strong class="text-black-50">Nama Toko</strong>
                            </div>
                            <div class="col-md-8">
                                {{$store->name}}
                            </div>
                        </div>
                        <div class="row my-2">
                            <div class="col-md-4">
                                <strong class="text-black-50">Balance (Saldo Toko)</strong>
                            </div>
                            <div class="col-md-8">
                                @priceIDR($store->balance)
                            </div>
                        </div>
                        @if ($store->verified_at)
                        <div class="row my-2">
                            <div class="col-md-4">
                                <strong class="text-black-50">Diverifikasi pada</strong>
                            </div>
                            <div class="col-md-8">
                                {{ $store->verified_at->format('d F Y H:i A') }}
                            </div>
                        </div>
                        @endif
                        @if ($store->phone)
                        <div class="row my-2">
                            <div class="col-md-4">
                                <strong class="text-black-50">Nomor WhatsApp</strong>
                            </div>
                            <div class="col-md-8">
                                <a href="https://wa.me/{{$store->phone}}">WA ({{$store->phone}}) <i class="fab fa-whatsapp"></i></a>
                            </div>
                        </div>
                        @endif
                        <div class="row my-2">
                            <div class="col-md-4">
                                <strong class="text-black-50">Alamat</strong>
                            </div>
                            <div class="col-md-8">
                                {{ $store->address }}
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-whitesmoke">
                        <div class="btn-group float-right">
                            <a href="{{ route('seller.store.edit') }}" class="btn btn-warning">Edit <i class="fa fa-edit"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="card card-warning">
                    <div class="card-header">
                        <h4>Gambar Toko</h4>
                        <div class="card-header-action">
                            <a data-collapse="#banner_img" class="btn btn-icon btn-primary" href="#"><i class="fas fa-minus"></i></a>
                        </div>
                    </div>
                    <div class="collapse show" id="banner_img">
                        <div class="card-body">
                            <div class="text-center">
                                <img src="{{$store->image_url}}" alt="{{$store->name}}'s banner" class="img-fluid">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h4>Produk <span class="badge badge-primary">{{$store->products->count()}}</span></h4>
                        <div class="card-header-action">
                            <a href="{{route('seller.products.create')}}" class="btn btn-primary">Tambah Produk <i class="fa fa-plus"></i></a>
                        </div>
                    </div>
                    <div class="card-body">
                        @include('partials.alerts')
                        <div class="table-responsive">
                            <table class="table table-stripped table-hover" id="products">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama</th>
                                    <th>Kategori</th>
                                    <th>Harga</th>
                                    <th>Stok</th>
                                    <th>Berat</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($store->products as $product)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td><a href="{{route('seller.products.show', $product->id)}}">{{$product->name}}</a></td>
                                        <td>{{$product->category->name}}</td>
                                        <td>@priceIDR($product->price)</td>
                                        <td>{{$product->stock}}</td>
                                        <td>{{$product->weight.' '.$product->weight_unit}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card card-info">
                    <div class="card-header">
                        <h4>Riwayat Saldo</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-stripped" id="balances">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Jumlah</th>
                                    <th>Tipe Saldo</th>
                                    <th>Deskripsi</th>
                                    <th>Dibuat pada</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($store->balances as $balance)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>@priceIDR($balance->amount)</td>
                                        <td>{{$balance->type_string}}</td>
                                        <td style="word-wrap: break-word">{{$balance->description}}</td>
                                        <td>{{$balance->created_at}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr class="bg-whitesmoke">
                                    <td>Total Saldo</td>
                                    <td>@priceIDR($store->balance)</td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('javascript')
    <script>
        $(function () {
            $('#products').DataTable();
            $('#balances').DataTable();
        })
    </script>
@endpush
