@extends('layouts.app')

@section('title', 'Create Community Product')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Create Community Product</h1>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h4>Community Product</h4>
                        </div>
                        <div class="card-body">
                            @include('partials.alerts')
                            <form action="{{ route('admin.products.store') }}" enctype="multipart/form-data" method="POST">
                                @csrf

                                <div class="form-group">
                                    <label for="name">Nama Produk</label>
                                    <input type="text" autocomplete="name" name="name" id="name" placeholder="Product name" class="form-control" value="{{ old('name') }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="store_id">Toko</label>
                                    <select name="store_id" id="store_id" class="form-control select2" required>
                                        @foreach($stores as $id => $name)
                                            <option value="{{$id}}" {{old('store_id') === $id ? 'checked' : ''}}>{{$name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="product_category_id">Kategori</label>
                                    <select name="product_category_id" id="product_category_id" class="form-control select2" required>
                                        @foreach($categories as $id => $name)
                                            <option value="{{$id}}" {{old('product_category_id') === $id ? 'selected' : ''}}>{{$name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-6">
                                        <label for="price">Harga</label>
                                        <input type="number" name="price" id="price" placeholder="10000" min="0" class="form-control" value="{{old('price')}}" required>
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="stock">Stock</label>
                                        <input type="number" min="1" name="stock" id="stock" placeholder="1" class="form-control" value="{{old('stock')}}" required>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-6">
                                        <label for="weight">Berat</label>
                                        <input type="number" name="weight" id="weight" placeholder="Berat dalam angka" class="form-control" value="{{old('weight')}}" required>
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="weight_unit">Satuan Berat</label>
                                        <select name="weight_unit" id="weight_unit" class="form-control">
                                            <option value="g" selected>Gram</option>
                                            <option value="kg">Kilo Gram</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="description">Deskripsi</label>
                                    <textarea name="description" id="description" cols="30" rows="10"
                                              class="form-control summernote">{{old('description')}}</textarea>
                                </div>

                                <div class="form-group" id="extra_info_wrapper">
                                    <label for="extra_info">Extra Info</label>
                                    <span class="form-text text-muted">
                                        Informasi tambahan
                                    </span>
                                    <div class="d-flex my-2 extra-info-template">
                                        <div class="col-md-4">
                                            <input type="text" name="extra_keys[]" placeholder="kualitas" class="form-control form-control-sm">
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" name="extra_values[]" placeholder="asli" class="form-control form-control-sm">
                                        </div>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-sm btn-info btn-add-extra-info">Add <i class="fa fa-plus"></i></button>
                                            <button type="button" class="btn btn-sm btn-danger btn-remove-extra-info">Remove <i class="fa fa-times"></i></button>
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-md btn-primary">Create <i class="fa fa-save"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('javascript')
    <script>
        $(function() {
            $('#extra_info_wrapper').on('click', 'button.btn-add-extra-info', function () {
                $($('.extra-info-template').clone().removeClass('.extra-info-template')[0].outerHTML).appendTo('#extra_info_wrapper');
            })

            $('#extra_info_wrapper').on('click', 'button.btn-remove-extra-info', function () {
                $(this).parent().parent().remove();
            })
        })
    </script>
@endpush
