@extends('layouts.app')

@section('title', 'Pesanan #'. $order->id)

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Pesanan #{{$order->id}}</h1>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    @include('partials.alerts')
                    <div class="wizard-steps">
                        <div class="wizard-step wizard-step-active">
                            <div class="wizard-step-icon">
                                <i class="fas fa-coffee"></i>
                            </div>
                            <div class="wizard-step-label">
                                Customer Memesan <br>
                                <small class="text-white">{{$order->created_at}}</small>
                            </div>
                        </div>
                        <div class="wizard-step wizard-step-{{$order->confirmed_at === null ? 'warning' : 'active'}}">
                            <div class="wizard-step-icon">
                                <i class="fas fa-{{$order->confirmed_at === null ? 'stopwatch' : 'money-bill-wave'}}"></i>
                            </div>
                            <div class="wizard-step-label">
                                Pembayaran Terkonfirmasi <br>
                                <small>{{$order->confirmed_at}}</small>
                            </div>
                        </div>
                        <div class="wizard-step {{$order->status === \App\Models\Order::STATUS_ON_DELIVERY || $order->shipping->status === \App\Models\Shipping::STATUS_SHIPPED ? 'wizard-step-active' : ''}}">
                            <div class="wizard-step-icon">
                                <i class="fas fa-shipping-fast"></i>
                            </div>
                            <div class="wizard-step-label">
                                Pesanan Terkirim <br>
                                @if ($order->status === \App\Models\Order::STATUS_ON_DELIVERY || $order->shipping->status === \App\Models\Shipping::STATUS_SHIPPED)
                                <small>{{$order->shipping->updated_at}}</small>
                                @endif
                            </div>
                        </div>
                        <div class="wizard-step {{$order->status === \App\Models\Order::STATUS_COMPLETED ? 'wizard-step-success' : ''}}">
                            <div class="wizard-step-icon">
                                <i class="fas fa-{{$order->status === \App\Models\Order::STATUS_COMPLETED ? 'check' : 'stopwatch'}}"></i>
                            </div>
                            <div class="wizard-step-label">
                                Pesanan Selesai <br>
                                @if($order->status === \App\Models\Order::STATUS_COMPLETED)
                                <small>{{$order->updated_at}}</small>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="section-body">
            <div class="invoice">
                <div class="invoice-print" id="invoiceRoot">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="invoice-title">
                                <h2>Invoice</h2>
                                <strong>#{{$payment->invoice->number}}</strong>
                                <div class="invoice-number">Order #{{$payment->invoice->order->id}}</div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <address>
                                        <strong>Dibayar kepada:</strong><br>
                                        @php $store = $payment->invoice->order->store; @endphp
                                        {{$store->name}}<br>
                                        {{$store->address}}<br>
                                        {{$store->city->name}}, {{$store->province->name}}<br>
                                        {{$store->phone}}
                                    </address>
                                </div>
                                <div class="col-md-6 text-md-right">
                                    <address>
                                        <strong>Dikirim kepada:</strong><br>
                                        @php $shipping = $payment->invoice->order->shipping->userAddress; @endphp
                                        {{$shipping->name}}<br>
                                        {{$shipping->address}}<br>
                                        {{$shipping->city->name}}, {{$shipping->province->name}}<br>
                                        {{$shipping->zipcode}} <br>
                                        {{$shipping->phone}}
                                    </address>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6"></div>
                                <div class="col-md-6 text-md-right">
                                    <address>
                                        <strong>Order Date:</strong><br>
                                        {{$payment->invoice->order->created_at}}<br><br>
                                    </address>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="section-title">Ringkasan Pesanan</div>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover table-md">
                                    <tbody><tr>
                                        <th data-width="40" style="width: 40px;">#</th>
                                        <th>Item</th>
                                        <th class="text-center">Price</th>
                                        <th class="text-center">Quantity</th>
                                        <th class="text-right">Totals</th>
                                    </tr>
                                    @foreach($payment->invoice->order->items as $item)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$item->product->name}}</td>
                                            <td class="text-center">@priceIDR($item->price)</td>
                                            <td class="text-center">{{$item->quantity}}</td>
                                            <td class="text-right">@priceIDR($item->price * $item->quantity)</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="row mt-4">
                                <div class="col-lg-8"></div>
                                <div class="col-lg-4 text-right">
                                    <div class="invoice-detail-item">
                                        <div class="invoice-detail-name">Subtotal</div>
                                        <div class="invoice-detail-value">@priceIDR($payment->invoice->order->total)</div>
                                    </div>
                                    <div class="invoice-detail-item">
                                        <div class="invoice-detail-name">PPN (10%)</div>
                                        <div class="invoice-detail-value">@priceIDR($payment->invoice->order->ppn)</div>
                                    </div>
                                    <div class="invoice-detail-item">
                                        <div class="invoice-detail-name">Shipping</div>
                                        <div class="invoice-detail-value">@priceIDR($payment->invoice->order->shipping_cost)</div>
                                    </div>
                                    <hr class="mt-2 mb-2">
                                    <div class="invoice-detail-item">
                                        <div class="invoice-detail-name">Total</div>
                                        <div class="invoice-detail-value invoice-detail-value-lg">@priceIDR($payment->invoice->order->total_amount)</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="text-md-right">
                    <button class="btn btn-warning btn-icon icon-left" onclick="printJS('invoiceRoot', 'html')"><i class="fas fa-print"></i> Print</button>
                </div>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-info">
                        <div class="card-header">
                            <h4>Informasi Pengiriman</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{route('seller.orders.update', $order->id)}}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="tracking_code">Nomor Resi</label>
                                    <input type="text" class="form-control" minlength="5" name="tracking_code" id="tracking_code" required value="{{old('tracking_code', $order->shipping->tracking_code)}}" @if(!empty($order->shipping->tracking_code)) disabled readonly @endif
                                    <small class="text-muted form-text">Anda tidak dapat merubah nomor resi setelah disimpan. Pastikan anda mengisi dengan benar</small>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-6">
                                        <label for="shipper">Jasa Pengiriman</label>
                                        <input type="text" readonly value="{{strtoupper($order->shipping->shipper)}}" class="form-control">
                                        <small class="text-muted form-text">Anda harus mengirim sesuai dengan jasa pengiriman di atas.</small>
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="service">Layanan Pengiriman</label>
                                        <input type="text" readonly value="{{$order->shipping->service}}" class="form-control">
                                    </div>
                                </div>
                                <p>Dengan mengklik tombol Simpan, berarti Anda sudah mengirim produk dan sudah mendapatkan nomor tracking. Pesanan akan dirubah statusnya menjadi Terkirim.</p>
                                <button class="btn btn-md btn-primary" @if(!empty($order->shipping->tracking_code)) disabled @endif>Simpan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('javascript')
    <script src="//printjs-4de6.kxcdn.com/print.min.js"></script>
@endpush
