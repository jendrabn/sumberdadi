@extends('layouts.app')

@section('title', 'Detail Payment')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Detail Payment: {{$payment->invoice->number}} (Status: {{$payment->status}})</h1>
        </div>
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
                                <div class="col-md-6">
                                    <address>
                                        <strong>Payment Method:</strong><br>
                                        {{strtoupper($payment->method)}}<br>
                                        @if ($payment->method === 'bank')
                                            Nomor Rekening: {{$payment->bank->account_number}}  - Bank: {{strtoupper($payment->bank->bank_code)}}
                                        @else
                                            Nomor Handphone: {{$payment->ewallet->phone_number}} - e-Wallet: {{strtoupper($payment->ewallet->wallet_type)}}
                                        @endif
                                    </address>
                                </div>
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
                                <div class="col-lg-8">
                                    <div class="section-title">Informasi Pembayaran</div>
                                    <p class="section-lead">Pastikan Anda telah menerima pembayaran sejumlah yang telah dibebankan sebelum menekan tombol Konfirmasi Pembayaran.</p>

                                </div>
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
                    <div class="float-lg-left mb-lg-0 mb-3">
                        <button id="confirmPayment" class="btn btn-primary btn-icon icon-left" @if($payment->status === 'RELEASED' || $payment->status === 'CANCELLED') disabled @endif><i class="fas fa-check"></i> Konfirmasi Pembayaran</button>
                        <button id="cancelPayment" class="btn btn-danger btn-icon icon-left" @if($payment->status !== 'PENDING') disabled @endif><i class="fas fa-times"></i> Batalkan Pesanan</button>
                    </div>
                    <button class="btn btn-warning btn-icon icon-left" onclick="printJS('invoiceRoot', 'html')"><i class="fas fa-print"></i> Print</button>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('javascript')
<script src="//printjs-4de6.kxcdn.com/print.min.js"></script>
<script>
    $(function() {
        $('#confirmPayment').on('click', function () {
            Swal.fire({
                title: 'Konfirmasi Pembayaran',
                input: 'checkbox',
                icon: 'warning',
                inputValue: 0,
                showCancelButton: true,
                focusCancel: true,
                inputPlaceholder: 'Saya sudah menerima pembayaran dengan jumlah yang sudah tertera',
                confirmButtonText: 'Konfirmasi <i class="fas fa-check"></i>',
                inputValidator: (result) => {
                    return !result && 'Anda harus memastikan pembayaran sudah diterima'
                }
            }).then(result => {
                if (result.value) {
                    $.ajax({
                        url: '{{route('admin.payments.update', $payment->id)}}',
                        method: 'PUT',
                        data: {
                            action: 'accept',
                        },
                        dataType: 'json'
                    }).then(function (data) {
                        if (data.status) {
                            Swal.fire('Sukses!', 'Pesanan sudah terkonfirmasi dan akan diteruskan ke penjual', 'success');
                            setTimeout(() => {
                                window.location.href = '{{route('admin.payments.index')}}';
                            }, 8000);
                        } else {
                            Swal.fire('Gagal!', data.message, 'error');
                        }
                    }).fail(function (xhr, status, error) {
                        let err = JSON.parse(xhr.responseText);
                        Swal.fire('Gagal!', 'Error: ' + err.message, 'error');
                    })
                }
            })
        });
        $('#cancelPayment').on('click', function () {
            Swal.fire({
                title: 'Konfirmasi Pembatalan Pesanan',
                input: 'checkbox',
                icon: 'danger',
                inputValue: 0,
                showCancelButton: true,
                focusCancel: true,
                inputPlaceholder: 'Saya akan membatalkan pesanan ini',
                confirmButtonText: 'Batalkan <i class="fas fa-times"></i>',
                confirmButtonColor: '#d33',
                inputValidator: (result) => {
                    return !result && 'Anda harus mengkonfirmasi pembatalan ini'
                }
            }).then(result => {
                if (result.value) {
                    $.ajax({
                        url: '{{route('admin.payments.update', $payment->id)}}',
                        method: 'PUT',
                        data: {
                            action: 'reject',
                        },
                        dataType: 'json'
                    }).then(function (data) {
                        if (data.status) {
                            Swal.fire('Sukses!', 'Pesanan telah dibatalkan!', 'success');
                            setTimeout(() => {
                                window.location.href = '{{route('admin.payments.index')}}';
                            }, 8000);
                        } else {
                            Swal.fire('Gagal!', data.message, 'error');
                        }
                    }).fail(function (xhr, status, error) {
                        let err = JSON.parse(xhr.responseText);
                        Swal.fire('Gagal!', 'Error: ' + err.message, 'error');
                    })
                }
            })
        });
    });
</script>
@endpush

