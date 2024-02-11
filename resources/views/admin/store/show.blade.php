@extends('layouts.app')

@section('title', $store->name)

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Store: {{$store->name}}</h1>
        </div>
        <div class="row">
            <div class="col-8">
                <div class="card card-primary">
                    <div class="card-header">
                        <h4>Detail Store: {{$store->name}}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row my-2">
                            <div class="col-md-2">
                                <strong class="text-black-50">Name</strong>
                            </div>
                            <div class="col-md-10">
                                {{$store->name}}
                            </div>
                        </div>
                        <div class="row my-2">
                            <div class="col-md-2">
                                <strong class="text-black-50">Community</strong>
                            </div>
                            <div class="col-md-10">
                                <a href="{{route('admin.communities.show', $store->community->id)}}">{{$store->community->name}}</a>
                            </div>
                        </div>
                        <div class="row my-2">
                            <div class="col-md-2">
                                <strong class="text-black-50">Balance</strong>
                            </div>
                            <div class="col-md-10">
                                @priceIDR($store->balance)
                            </div>
                        </div>
                        @if ($store->verified_at)
                        <div class="row my-2">
                            <div class="col-md-2">
                                <strong class="text-black-50">Verified At</strong>
                            </div>
                            <div class="col-md-10">
                                {{ $store->verified_at->format('d F Y H:i A') }}
                            </div>
                        </div>
                        @endif
                        @if ($store->phone)
                        <div class="row my-2">
                            <div class="col-md-2">
                                <strong class="text-black-50">Phone</strong>
                            </div>
                            <div class="col-md-10">
                                <a href="https://wa.me/{{$store->phone}}">WA ({{$store->phone}}) <i class="fab fa-whatsapp"></i></a>
                            </div>
                        </div>
                        @endif
                        <div class="row my-2">
                            <div class="col-md-2">
                                <strong class="text-black-50">Address</strong>
                            </div>
                            <div class="col-md-10">
                                {{ $store->address }}
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-whitesmoke">
                        <div class="btn-group float-right">
                            <button class="btn btn-outline-danger btn-delete-store">Delete <i class="fa fa-trash"></i></button>
                            <a href="{{ route('admin.stores.edit', $store->slug) }}" class="btn btn-warning">Edit <i class="fa fa-edit"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="card card-warning">
                    <div class="card-header">
                        <h4>Profile Picture</h4>
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
                        <h4>Products <span class="badge badge-primary">{{$store->products->count()}}</span></h4>
                        <div class="card-header-action">
                            <a href="{{route('admin.products.create')}}" class="btn btn-primary">Add <i class="fa fa-plus"></i></a>
                        </div>
                    </div>
                    <div class="card-body">
                        @include('partials.alerts')
                        <div class="table-responsive">
                            <table class="table table-stripped table-hover" id="products">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Category</th>
                                    <th>Price</th>
                                    <th>Stock</th>
                                    <th>Created At</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($store->products as $product)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td><a href="{{route('admin.products.show', $product->slug)}}">{{$product->name}}</a></td>
                                        <td>{{$product->category->name}}</td>
                                        <td>@priceIDR($product->price)</td>
                                        <td>{{$product->stock}}</td>
                                        <td>{{$product->created_at}}</td>
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
                        <h4>Balances</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-stripped" id="balances">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Amount</th>
                                    <th>Type</th>
                                    <th>Description</th>
                                    <th>Created At</th>
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
                                    <td>Total</td>
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

    <form action="{{route('admin.stores.destroy', $store->slug)}}" id="formDeleteStore" method="POST">
        @method('DELETE')
        @csrf
    </form>

@endsection

@push('javascript')
    <script>
        $(function () {
            $('button.btn-delete-store').on('click', function () {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'Delete',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#formDeleteStore').submit();
                    }
                })
            })
            $('#products').DataTable();
            $('#balances').DataTable();
        })
    </script>
@endpush
