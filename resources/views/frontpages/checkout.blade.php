@extends('layouts.front')

@section('title', 'Checkout')

@section('header')
    <section class="section-pagetop bg">
        <div class="container">
            <h2 class="title-page">Checkout</h2>
        </div> <!-- container //  -->
    </section>
@endsection

@section('content')
    @php $canCheckout = true; @endphp
    <section class="section-content padding-y-sm">
        <div class="container">
            <div class="row">
                <main class="col-md-9">
                    <form action="{{route('checkout.process')}}" method="POST" id="checkout">
                        @csrf
                    <article class="card mb-4">
                        <div class="card-body">
                            <h4 class="card-title mb-4">Informasi Keranjang Belanja</h4>
                            <div class="row">
                                <div class="col-12">
                                    @include('partials.error_alert')
                                    @if ($cart->totalStores() > 1)
                                    <div class="alert alert-info">
                                        <p><i class="fa fa-info-circle"></i> Anda akan membeli produk dengan {{$cart->totalStores()}} toko yang berbeda</p>
                                    </div>
                                    @endif

                                    @if ($cart->hasOverWeightItems())
                                        @php $canCheckout = false; @endphp
                                        <div class="alert alert-danger">
                                            <p><i class="fa fa-info-circle"></i> Maksimal berat yang diterima oleh jasa pengiriman adal 30 Kg</p>
                                            <p>Anda akan membeli barang yang melebih total berat yang telah ditentukan, silahkan <a href="{{route('cart')}}">mengurangi kuantitas produk</a> terlebih dahulu!</p>
                                        </div>
                                    @endif

                                    <p class="my-2">Jumlah Barang: {{$cart->items()->count()}} <br>Berat: {{$cart->totalWeightStr()}}</p>
                                </div>
                                @foreach ($cartItems as $item)
                                <div class="col-md-6">
                                    <figure class="itemside  mb-4">
                                        <div class="aside"><img src="{{optional($item->product->images()->first())->image_url}}" loading="lazy" class="border img-sm"></div>
                                        <figcaption class="info">
                                            <a href="{{route('product.show', [$item->product->store->slug, $item->product->slug])}}" target="new">{{$item->product->name}}</a>
                                            <p class="text-muted">{{$item->product->store->name}}</p>
                                            <p class="text-muted">Berat: {{$item->product->weight}} {{$item->product->weight_unit}}</p>
                                            <span class="text-muted">{{$item->quantity}}x = @priceIDR($item->total_price)</span>
                                        </figcaption>
                                    </figure>
                                </div> <!-- col.// -->
                                @endforeach
                            </div> <!-- row.// -->
                        </div> <!-- card-body.// -->
                    </article>

                    <article class="card mb-4">
                        <div class="card-body">
                            <h4 class="card-title mb-4">Alamat Penerima</h4>

                            <div class="row">
                                <div class="form-group col-sm-12">
                                    <label for="shipping_name">Nama Penerima</label>
                                    <input type="text" class="form-control" name="shipping_name" value="{{old('shipping_name', $address->name ?? auth()->user()->full_name)}}" required>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="shipping_province_id">Provinsi*</label>
                                    <select name="shipping_province_id" id="shipping_province_id" class="form-control select2" required>
                                    </select>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="shipping_city_id">Kota*</label>
                                    <select name="shipping_city_id" id="shipping_city_id" class="form-control select2" required>
                                    </select>
                                </div>
                                <div class="form-group col-sm-8">
                                    <label for="shipping_address">Alamat Rumah</label>
                                    <input type="text" name="shipping_address" id="shipping_address" value="{{old('shipping_address', $address->address ?? '')}}" placeholder="Jl." class="form-control" required>
                                </div>
                                <div class="form-group col-sm-4">
                                    <label for="shipping_zipcode">Kode Pos</label>
                                    <input type="text" name="shipping_zipcode" id="shipping_zipcode" class="form-control" value="{{old('shipping_zipcode', $address->zipcode ?? '')}}" required>
                                </div>
                                <div class="form-group col-sm-4">
                                    <label for="shipping_phone">Nomor HP</label>
                                    <input type="text" name="shipping_phone" id="shipping_phone" value="{{old('shipping_phone', $address->phone ?? '')}}" placeholder="62" class="form-control" required>
                                </div>
                            </div> <!-- row.// -->
                        </div> <!-- card-body.// -->
                    </article>

                    <article class="card mb-4">
                        <div class="card-body shipping-method">
                            <h4 class="card-title mb-4">Metode Pengiriman</h4>
                            @if ($cart->totalStores() > 1)
                                <div class="alert alert-info">
                                    <p><i class="fa fa-info-circle"></i> Karena Anda akan membeli di {{$cart->totalStores()}} toko yang berbeda, maka Anda harus memilih metode pengiriman untuk tiap toko.</p>
                                </div>
                            @endif
                            @foreach($cart->allStores() as $item)
                            <div class="row shipment" data-city="{{$item->product->store->city->id}}">
                                <div class="form-group col-md-6">
                                    <label>{{$loop->iteration}}. {{$item->product->store->name}} (Kota: {{$item->product->store->city->name}})<br>Berat: {{$cart->totalWeightStr($cart->weightFromStore($item->store_id))}}<br> <span class="harga"></span></label>
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Kurir</label>
                                    <select name="shipping_methods[{{$item->store_id}}]" data-city="{{$item->product->store->city->id}}" data-weight="{{$cart->weightFromStore($item->store_id)}}" class="form-control shipping_methods">
                                        <option value="-1" selected>Pilih</option>
                                        <option value="JNE">JNE</option>
                                        <option value="POS">POS</option>
                                        <option value="TIKI">TIKI</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Layanan</label>
                                    <select name="shipping_services[{{$item->store_id}}]" data-price="0" class="form-control shipping-services" disabled></select>
                                </div>
                            </div>
                            @endforeach
                        </div> <!-- card-body.// -->
                    </article>

                    <article class="accordion" id="accordion_pay">
                        <div class="card">
                            <header class="card-header">
                                <img src="{{asset('images/misc/payment-bank.svg')}}" class="float-right" height="24">
                                <label class="form-check" data-toggle="collapse" data-target="#accordionBank" aria-expanded="true">
                                    <input class="form-check-input" name="payment_method" type="radio" value="bank" checked>
                                    <h6 class="form-check-label"> Bank Transfer (BCA, BRI, BNI) </h6>
                                </label>
                            </header>
                            <div id="accordionBank" class="collapse show" data-parent="#accordion_pay">
                                <div class="card-body">
                                    <p class="text-muted">Silahkan membayar sesuai total belanja dengan menggunakan bank yang tersedia, lalu isi nomor rekening dan pilih bank yang anda gunakan saat transaksi</p>
                                    <p>
                                        BCA: 200058293 (a.n J.Coffee) <br>
                                        BRI: 3920852193491 (a.n J.Coffee) <br>
                                        BNI: 3920852193493 (a.n J.Coffee)
                                    </p>
                                    <div class="row">
                                        <div class="form-group col-6">
                                            <label for="account_number">Nomor Rekening</label>
                                            <input type="number" name="account_number" id="account_number" class="form-control" placeholder="Nomor Rekening Anda" value="{{old('account_number')}}">
                                        </div>
                                        <div class="form-group col-6">
                                            <label for="bank">Nama Bank</label>
                                            <select name="bank" id="bank" class="form-control">
                                                <option value="-1" selected>Pilih Bank</option>
                                                <option value="BCA" {{old('bank') === 'BCA' ? 'selected' : ''}}>BCA</option>
                                                <option value="BRI" {{old('bank') === 'BRI' ? 'selected' : ''}}>BRI</option>
                                                <option value="BNI" {{old('bank') === 'BNI' ? 'selected' : ''}}>BNI</option>
                                                <option value="MANDIRI" {{old('bank') === 'MANDIRI' ? 'selected' : ''}}>MANDIRI</option>
                                                <option value="CIMBNIAGA" {{old('bank') === 'CIMBNIAGA' ? 'selected' : ''}}>CIMB NIAGA</option>
                                                <option value="BANKJATIM" {{old('bank') === 'BANKJATIM' ? 'selected' : ''}}>Bank JATIM</option>
                                            </select>
                                        </div>
                                    </div>
                                </div> <!-- card body .// -->
                            </div> <!-- collapse .// -->
                        </div> <!-- card.// -->
                        <div class="card">
                            <header class="card-header">
                                <img src="{{asset('images/misc/payment-gopay.png')}}" class="float-right" height="24">
                                <label class="form-check" data-toggle="collapse" data-target="#accordionEWallet">
                                    <input class="form-check-input" name="payment_method" type="radio" value="ewallet">
                                    <h6 class="form-check-label"> e-Wallet (Go Pay, LinkAja, OVO, Dana)  </h6>
                                </label>
                            </header>
                            <div id="accordionEWallet" class="collapse" data-parent="#accordion_pay">
                                <div class="card-body">
                                    <p class="text-muted">Pembayaran melalui e-Wallet dikirim ke nomor berikut, lalu isi nomor handphone yang digunakan saat transaksi:</p>
                                    GoPay: 08123456789 (a.n J.Coffee) <br>
                                    LinkAja: 08123456789 (a.n J.Coffee) <br>
                                    OVO: 08123456789 (a.n J.Coffee) <br>
                                    Dana: 08123456789 (a.n J.Coffee) <br>
                                    <div class="row mt-2">
                                        <div class="form-group col-6">
                                            <label for="phone_number">Nomor Handphone</label>
                                            <input type="number" name="phone_number" id="phone_number" placeholder="62" class="form-control" value="{{old('phone_number')}}">
                                        </div>
                                        <div class="form-group col-6">
                                            <label for="ewallet">e-Wallet</label>
                                            <select name="ewallet" id="ewallet" class="form-control">
                                                <option value="-1">Pilih e-Wallet</option>
                                                <option value="gopay" {{old('ewallet') === 'gopay' ? 'selected' : ''}}>GoPay</option>
                                                <option value="linkaja" {{old('ewallet') === 'linkaja' ? 'selected' : ''}}>LinkAja</option>
                                                <option value="dana" {{old('ewallet') === 'dana' ? 'selected' : ''}}>Dana</option>
                                                <option value="ovo" {{old('ewallet') === 'ovo' ? 'selected' : ''}}>OVO</option>
                                            </select>
                                        </div>
                                    </div>

                                </div> <!-- card body .// -->
                            </div> <!-- collapse .// -->
                        </div>
                    </article>

                    <article class="card my-4">
                        <div class="card-body">
                            <h5 class="card-title mb-4">Catatan untuk Pemesanan</h5>
                            <div class="row">
                                <div class="form-group col-sm-12">
                                    <label for="description">Pesan (opsional)</label>
                                    <textarea name="description" id="description" cols="15" rows="5" class="form-control" placeholder="Catatan pemesanan">{{old('description')}}</textarea>
                                </div>
                            </div> <!-- row.// -->
                        </div> <!-- card-body.// -->
                    </article>
                    </form>
                </main> <!-- col.// -->
                <aside class="col-md-3">
                    <div class="card shadow">
                        <div class="card-body">
                            <h4 class="mb-3">Total</h4>
                            <dl class="dlist-align">
                                <dt class="w-50">Sub total:</dt>
                                <dd class="text-right" id="subTotal">@priceIDR($subTotal)</dd>
                            </dl>
                            <dl class="dlist-align">
                                <dt class="w-50">PPN (10%):</dt>
                                <dd class="text-right" id="ppn">@priceIDR($ppn)</dd>
                            </dl>
                            <hr>
                            <dl class="dlist-align d-none" id="shippingPrice">
                                <dt class="w-30">Pengiriman</dt>
                                <dd class="text-right" id="shippingTotal"></dd>
                            </dl>
                            <hr>
                            <dl class="dlist-align">
                                <dt class="w-25">Total:</dt>
                                <dd class="text-right h5" id="grandTotal"><strong>@priceIDR($grandTotal)</strong></dd>
                            </dl>
                            <hr>
                            <p class="small mb-3 text-muted">Sebelum menekan tombol Selesai, pastikan anda sudah membayar dengan total yang dibebankan</p>
                            @if ($canCheckout)
                                <button id="btnSelesai" class="btn btn-primary btn-block"> Selesai  </button>
                            @else
                                <button class="btn btn-white btn-block"> Selesai </button>
                            @endif

                        </div> <!-- card-body.// -->
                    </div> <!-- card.// -->
                </aside>
            </div>

        </div> <!-- container .//  -->
    </section>
@endsection

@push('stylesheet')
    <link rel="stylesheet" href="{{ asset('css/components.css') }}">
@endpush


@push('javascript')
    <script>
        $(function () {
            let grandTotal = {{$grandTotal}};

            $('.shipment').on('change', '.shipping-services', function () {
                if ($(this).val() == -1) {
                    Toast.fire({title: 'Silahkan memilih layanan pengiriman', icon: 'warning'});
                    return;
                }
                let shippingTotal = getShippingTotal();
                $('#shippingPrice').removeClass('d-none');
                $('#shippingTotal').text(toRp(shippingTotal));
                $('#grandTotal').html(`<strong>${toRp(grandTotal + shippingTotal)}</strong>`);
            });

            $('#shipping_city_id').on('change', function () {
                $.each($('.shipping_methods'), function (index, shipping) {
                    $(shipping).parent().next().find('select').val('').attr('disabled', true);
                    $(shipping).val(-1);
                })
            });

            $('.shipping-method').on('change', '.shipping_methods', function (e) {
                let shipping_services = $(this).parent().next().find('select');

                if (!$('#shipping_city_id').val()) {
                    $(this).val(-1);
                    let apa = 'provinsi';
                    if ($('#shipping_province_id').val() == '') {
                        $('#shipping_city_id').select2('open');
                        apa = 'kota';
                    } else {
                        $('#shipping_province_id').select2('open');
                    }
                    return Toast.fire({title: `Silahkan mengisi ${apa} pengiriman`, icon: 'warning', timer: 8e3});
                }

                if ($(this).val() == -1) {
                    shipping_services.attr('disabled', true);
                    return Toast.fire({title: 'Silahkan memilih kurir', icon: 'warning'})
                }

                Toast.fire({title: 'Sedang memuat layanan pengiriman', icon: 'info'});
                shipping_services.attr('disabled', true);

                $.ajax({
                    url: '{{route('ajax.shipping')}}',
                    type: 'POST',
                    data: {
                        origin: $('#shipping_city_id').val(),
                        destination: $(this).data('city'),
                        courier: $(this).val(),
                        weight: $(this).data('weight')
                    },
                    dataType: 'json',
                }).then(function (data) {
                    shipping_services.empty();
                    shipping_services.attr('disabled', false)
                    if (data.results) {
                        shipping_services.append(new Option('Pilih layanan', -1));
                        $.each(data.results?.costs, function (index, service) {
                            let etd = service?.cost[0]?.etd ? service?.cost[0]?.etd?.replace('HARI', '') + ' hari' : '-';
                            let title = `${service?.description} - ${etd} - ${toRp(service?.cost[0]?.value)}`;
                            let option = new Option(title, service?.service);
                            shipping_services.append($(option).attr('data-price', service?.cost[0]?.value).html(title));
                        });
                    } else {
                        Toast.fire({title: 'Gagal memuat layanan! Silahkan mencoba lagi', icon: 'error'})
                    }
                }).fail(function (jqXHR, textStatus, error) {
                    Toast.fire({title: error, icon: 'error'});
                })
            });

            $('#shipping_province_id').select2({
                ajax: {
                    delay: 500,
                    type: 'GET',
                    url: '{{route('ajax.provinces')}}',
                    dataType: 'json',
                    processResults: function (data) {
                        let results = [];
                        $.each(data.results, function (i, v) {
                            results.push({id: i, text: v});
                        });

                        return {results}
                    }
                }
            });

            $('#shipping_city_id').select2({
                ajax: {
                    delay: 500,
                    type: 'GET',
                    url: function () {
                        return '{{url('ajax/cities')}}/' + $('#shipping_province_id').val()
                    },
                    processResults: function (data) {
                        let results = [];
                        $.each(data.results, function (i, v) {
                            results.push({id: i, text: v});
                        });

                        return {results}
                    }
                }
            })

            $('#btnSelesai').on('click', function() {
                let isReadyToCheckout = true;

                // shipping
                $.each($('.shipping-services'), function (index, shipping) {
                    if ($(shipping).val() == -1 || $(shipping).is(':disabled')) {
                        isReadyToCheckout = false;
                        Toast.fire({title: 'Mohon untuk memilih jenis layanan pengiriman', icon: 'warning'});
                        $(shipping).focus().select();
                        return false;
                    }
                });

                // payment
                $.each($('input[name=payment_method]'), function (index, paymentMethod) {
                    if ($(paymentMethod).is(':checked')) {
                        if ($(paymentMethod).val() === 'bank') {
                            if ($('#account_number').val() == '') {
                                isReadyToCheckout = false;
                                Toast.fire({title: 'Mohon untuk mengisi nomor rekening yang Anda gunakan untuk transaksi ini', icon: 'warning', timer: 8e3});
                                $('#account_number').focus();
                                return false;
                            }

                            if ($('#bank').val() == -1) {
                                isReadyToCheckout = false;
                                Toast.fire({title: 'Mohon untuk memilih jenis bank yang Anda gunakan untuk transaksi ini', icon: 'warning', timer: 8e3});
                                $('#bank').focus().select();
                                return false;
                            }
                        }

                        if ($(paymentMethod).val() === 'ewallet') {
                            if ($('#phone_number').val() == '') {
                                isReadyToCheckout = false;
                                Toast.fire({title: 'Mohon untuk mengisi nomor handphone yang Anda gunakan untuk transaksi ini', icon: 'warning', timer: 8e3});
                                $('#phone_number').focus();
                                return false;
                            }

                            if ($('#ewallet').val() == -1) {
                                isReadyToCheckout = false;
                                Toast.fire({title: 'Mohon untuk mengisi jenis e-Wallet yang Anda gunakan untuk transaksi ini', icon: 'warning', timer: 8e3});
                                $('#ewallet').focus().select();
                                return false;
                            }
                        }
                    }
                });

                if (isReadyToCheckout) {
                    $(this).attr('disabled', true);
                    $('#checkout').submit();
                }
            });

            function toRp(angka) {
                let rupiah = '';
                let angkarev = angka.toString().split('').reverse().join('');
                for(let i = 0; i < angkarev.length; i++) if(i%3 === 0) rupiah += angkarev.substr(i,3)+'.';
                return 'Rp. '+rupiah.split('',rupiah.length-1).reverse().join('');
            }

            function getShippingTotal() {
                let total = 0;
                $.each($('select.shipping-services>option:checked'), function (index, option) {
                    total += parseInt($(this).data('price'));
                });

                return total;
            }
        })
    </script>
@endpush

