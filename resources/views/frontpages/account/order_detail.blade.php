@extends('layouts.front')

@section('title', 'Detail Pesanan #'.$order->id)

@section('header')
    <section class="section-pagetop bg">
        <div class="container">
            <h2 class="title-page">Detail Pesanan #{{$order->id}}</h2>
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
                            <a href="{{route('user.orders')}}" class="btn btn-sm btn-primary"><i class="fa fa-arrow-left"></i></a>
                            <strong class="d-inline-block mx-3">Order ID: #{{$order->id}}</strong>
                            <strong class="d-inline-block mx-3">Invoice: {{$order->invoice->number}}</strong>
                            <span class="d-inline-block mx-3">Tanggal Pesanan: {{$order->created_at->format('d F Y')}}</span>
                        </header>
                        <div class="card-body">
                            @include('partials.alerts')
                            <div class="row">
                                <div class="col-md-4">
                                    <h6 class="text-muted">Alamat Pengiriman</h6>
                                    @php $address = auth()->user()->addresses->first(); @endphp
                                    <p>{{$address->name}} <br>
                                        {{$address->address}}, {{$address->city->name}}, {{$address->province->name}} <br>
                                        Kode Pos: {{$address->zipcode}} <br> Nomor HP: {{$address->phone}}
                                    </p>
                                </div>
                                <div class="col-md-4">
                                    <h6 class="text-muted">Penjual</h6>
                                    <p>{{$order->store->name}}</p>
                                        Dari: {{$order->store->city->name}}, {{$order->store->province->name}} <br>
                                        No HP: {{$order->store->phone}}
                                </div>
                                <div class="col-md-4">
                                    <h6 class="text-muted">Pembayaran</h6>
                                    <span class="text-success">
                                @php $payment = $order->invoice->payments->first(); @endphp
                                {{ucfirst($payment->method)}}: {{$payment->method === 'bank' ? strtoupper("{$payment->bank->bank_code} ({$payment->bank->account_number})") : strtoupper("{$payment->ewallet->wallet_type} ({$payment->ewallet->phone_number})")}}
                            </span>
                                    <p>Subtotal: @priceIDR($order->total) <br>
                                        PPN: @priceIDR($order->ppn) <br>
                                        Shipping: @priceIDR($order->shipping_cost) <br>
                                        <span class="b">Total:  @priceIDR($order->total + $order->ppn + $order->shipping_cost) </span>
                                    </p>
                                </div>
                            </div> <!-- row.// -->
                        </div> <!-- card-body .// -->
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <tbody>
                                @foreach ($order->items as $item)
                                <tr>
                                    <td width="65">
                                        <img src="{{optional($item->product->images->first())->image_url}}" class="img-xs border">
                                    </td>
                                    <td>
                                        <p class="title mb-0"><a href="{{route('product.show', [$item->product->store->slug, $item->product->slug])}}">{{$item->product->name}}</a></p>
                                        <var class="price text-muted">@priceIDR($item->price) | Qty: {{$item->quantity}}</var>
                                    </td>
                                    <td>@priceIDR($item->price * $item->quantity)</td>
                                    @if ($order->status === \App\Models\Order::STATUS_ON_DELIVERY)
                                    <td>Nomor Resi: {{$order->shipping->tracking_code}} <br> Dikirim oleh {{strtoupper($order->shipping->shipper)}} {{$order->shipping->service}}
                                        <br>Perkiraan tiba: {{$order->shipping->estimated_delivery}} hari  </td>
                                    @endif
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                            @if($order->status === \App\Models\Order::STATUS_ON_DELIVERY)
                                <hr>
                                <div class="mx-4 my-4">
                                    <p>Apabila anda sudah menerima pesanan, mohon untuk klik tombol berikut.</p>
                                    <form action="{{route('user.orders.update', $order->id)}}" id="formAction" method="POST">
                                        @csrf @method('PUT')
                                        <button type="submit" id="btnComplete" class="btn btn-md btn-primary">SELESAI</button>
                                    </form>
                                </div>
                            @endif
                        </div> <!-- table-responsive .end// -->
                    </article> <!-- order-group.// -->
                </main>
            </div>
        </div>
    </section>
@endsection

@push('javascript')
    <script>
        $(function() {
            $('#btnComplete').on('click', function (e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Konfirmasi Selesai',
                    input: 'checkbox',
                    icon: 'warning',
                    inputValue: 0,
                    showCancelButton: true,
                    focusCancel: true,
                    inputPlaceholder: 'Saya sudah menerima barang dan sesuai dengan apa yang saya pesan',
                    confirmButtonText: 'Konfirmasi <i class="fas fa-check"></i>',
                    inputValidator: (result) => {
                        return !result && 'Anda harus memastikan bahwa barang sudah diterima'
                    }
                }).then(result => {
                    if (result.value) {
                        $('#formAction').submit();
                    }
                });
            })
        });
    </script>
@endpush
