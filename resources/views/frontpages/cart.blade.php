@extends('layouts.front')

@section('title', 'Keranjang Belanja')

@section('header')
    <section class="section-pagetop bg">
        <div class="container">
            <h2 class="title-page">Keranjang Belanja</h2>
        </div> <!-- container //  -->
    </section>
@endsection

@section('content')
    <section class="section-content padding-y-sm">
        <div class="container">
            <div class="row">
                <main class="col-md-9">
                    <div class="card">
                        @include('partials.alerts')
                        @if($cart->totalWeight() < 1000)
                        <div class="alert alert-warning">
                            <p>Minimal total berat produk untuk pemesanan yaitu 1 kg</p>
                        </div>
                        @endif
                        <table class="table table-borderless table-shopping-cart">
                            <thead class="text-muted">
                            <tr class="small text-uppercase">
                                <th scope="col">Product</th>
                                <th scope="col" width="120">Quantity</th>
                                <th scope="col" width="120">Price</th>
                                <th scope="col" class="text-right" width="200"> </th>
                            </tr>
                            </thead>
                            <tbody>
                            @if (empty($cartItems))
                                <tr>
                                    <td colspan="3">Keranjang Belanja kosong</td>
                                </tr>
                            @endif
                            @foreach($cartItems as $item)
                            <tr class="cart-row">
                                <td>
                                    <figure class="itemside">
                                        <div class="aside"><img src="{{optional($item->product->images->first())->image_url}}" class="img-sm rounded mx-auto d-block"></div>
                                        <figcaption class="info">
                                            <a href="{{route('product.show', [$item->product->store->slug, $item->product->slug])}}" class="title text-dark">{{$item->product->name}}</a>
                                            <p class="text-muted small">Kategori: {{$item->product->category->name}}<br> Toko: {{$item->product->store->name}}
                                                <br>Berat: {{$item->product->weight .' '. $item->product->weight_unit}}</p>
                                        </figcaption>
                                    </figure>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <div class="input-group mb-3 input-spinner">
                                            <div class="input-group-prepend">
                                                <button class="btn btn-light btn-increase-quantity" type="button" id="button-plus"> + </button>
                                            </div>
                                            <input type="text" class="form-control p-0 quantity" data-id="{{$item->product_id}}" data-price="{{$item->price}}" max="{{$item->product->stock}}" value="{{$item->quantity}}" min="1">
                                            <div class="input-group-append">
                                                <button class="btn btn-light btn-decrease-quantity" type="button" id="button-minus"> &minus; </button>
                                            </div>
                                        </div>
                                    </div> <!-- col.// -->
                                </td>
                                <td>
                                    <div class="price-wrap">
                                        <var class="price">@priceIDR($item->total_price)</var>
                                        <small class="text-muted">@priceIDR($item->price) / product</small>
                                    </div> <!-- price-wrap .// -->
                                </td>
                                <td class="text-right">
                                    <button class="btn btn-light btn-remove" data-id="{{$item->product_id}}"> Hapus <i class="fa fa-times"></i></button>
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div> <!-- card.// -->

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
                            <dl class="dlist-align">
                                <dt class="w-25">Total:</dt>
                                <dd class="text-right h5" id="grandTotal"><strong>@priceIDR($grandTotal)</strong></dd>
                            </dl>
                            <hr>
                            <p class="text-center mb-4">
                                <span class="text-muted my-2">Belum termasuk shipping</span>
                            </p>
                            @if (empty($cartItems))
                                <a href="#" class="btn btn-empty-cart btn-block btn-light" disabled> Checkout </a>
                            @elseif($cart->totalWeight() >= 1000)
                                <a href="{{route('checkout')}}" id="checkout" class="btn btn-block btn-primary"> Checkout </a>
                            @endif
                            <a href="{{route('products')}}" class="btn btn-block btn-light"> Continue shopping </a>
                        </div> <!-- card-body.// -->
                    </div>  <!-- card .// -->
                </aside> <!-- col.// -->
            </div>

        </div> <!-- container .//  -->
    </section>

@endsection

@push('stylesheet')
    <link rel="stylesheet" href="{{ asset('css/components.css') }}">
@endpush

@push('javascript')

    <script>
        $(function() {
            $('a.btn-empty-cart').on('click', function emptyCart() {
                Toast.fire({
                    title: 'Cart Kosong! Silahkan menambahkan produk terlebih dahulu',
                    icon: 'warning'
                });
            });

            let subTotal = $('#subTotal'), ppn = $('#ppn'), grandTotal = $('#grandTotal');
            $('tr.cart-row').on('click', 'button.btn-increase-quantity', function () {
                let spinner = $(this).parent().siblings('.quantity');
                let maxQty = parseInt(spinner.attr('max'))
                let currentVal = parseInt(spinner.val());
                if (currentVal + 1 > maxQty) {
                    return $(this).attr('disabled', true)
                }
                $(this).parent().siblings('div').children('button').attr('disabled', false)
                updateQuantity(spinner, currentVal+1)
            });

            $('tr.cart-row').on('click', 'button.btn-decrease-quantity', function () {
                let spinner = $(this).parent().siblings('.quantity');
                let minQty = parseInt(spinner.attr('min'))
                let currentVal = parseInt(spinner.val());
                if (currentVal - 1 < minQty) {
                    return $(this).attr('disabled', true)
                }
                $(this).parent().siblings('div').children('button').attr('disabled', false)
                updateQuantity(spinner, currentVal-1)
            });

            $('tr.cart-row').on('change', 'input.quantity', function () {
                let maxQty = parseInt($(this).attr('max'))
                let minQty = parseInt($(this).attr('min'))
                let currentVal = parseInt($(this).val());

                if (currentVal < minQty) {
                    return updateQuantity($(this), minQty);
                }
                if (currentVal > maxQty) {
                    return updateQuantity($(this), maxQty);
                }

                return updateQuantity($(this), currentVal);
            });

            $('tr.cart-row').on('click', 'button.btn-remove', function () {
                let parent = $(this).parents('tr.cart-row')
                let id = $(this).data('id');
                $.ajax({
                    url: '{{route('cart.delete_item')}}',
                    type: 'DELETE',
                    data: {
                        product_id: id
                    },
                    dataType: 'json'
                }).then(function () {
                    refresh();
                    parent.remove();
                }).fail(function (jq, text, err) {
                    Toast.fire({
                        title: `Error: ${text} - ${err}`,
                        icon: 'error'
                    })
                });
            });

            function refresh () {
                $.ajax({
                    url: '{{route('cart.refresh')}}',
                    type: 'get',
                    async: true,
                    dataType: 'json'
                }).then(function (data) {
                    subTotal.text(data.subTotal)
                    ppn.text(data.ppn)
                    grandTotal.text(data.grandTotal)
                }).fail(function (jq, text, err) {
                    Toast.fire({
                        title: `Error: ${text} - ${err}`,
                        icon: 'error'
                    })
                })
            }

            function updateQuantity(spinner, newQty) {
                $.ajax({
                    url: '{{route('cart.update_item')}}',
                    type: 'PUT',
                    async: true,
                    data: {
                        product_id: spinner.data('id'),
                        quantity: newQty
                    },
                    dataType: 'json'
                }).then(function (data) {
                    spinner.parents('tr.cart-row').find('td:nth-child(3) div.price-wrap var.price').text(data.total_price)
                    spinner.val(data.qty)
                    subTotal.text(data.subTotal)
                    ppn.text(data.ppn)
                    grandTotal.text(data.grandTotal)
                }).fail(function (jq, text, err) {
                    Toast.fire({
                        title: `Error: ${text} - ${err}`,
                        icon: 'error'
                    })
                })
            }
        })
    </script>
@endpush
