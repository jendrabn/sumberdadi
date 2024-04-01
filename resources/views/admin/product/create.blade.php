@extends('layouts.admin')

@section('title', 'Create Community Product')

@section('content_header')
  <div class="row mb-2">
    <div class="col-sm-6">
      <h1>Create Community Product</h1>
    </div>
  </div>
@endsection

@section('content')
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Community Product</h3>
        </div>
        <div class="card-body">
          @include('partials.alerts')
          <form action="{{ route('admin.products.store') }}"
            enctype="multipart/form-data"
            method="POST">
            @csrf

            <div class="form-group">
              <label for="name">Nama Produk</label>
              <input class="form-control"
                id="name"
                name="name"
                type="text"
                value="{{ old('name') }}"
                autocomplete="name"
                placeholder="Product name"
                required>
            </div>

            <div class="form-group">
              <label for="store_id">Toko</label>
              <select class="form-control select2"
                id="store_id"
                name="store_id"
                required>
                @foreach ($stores as $id => $name)
                  <option value="{{ $id }}"
                    {{ old('store_id') === $id ? 'checked' : '' }}>{{ $name }}</option>
                @endforeach
              </select>
            </div>

            <div class="form-group">
              <label for="product_category_id">Kategori</label>
              <select class="form-control select2"
                id="product_category_id"
                name="product_category_id"
                required>
                @foreach ($categories as $id => $name)
                  <option value="{{ $id }}"
                    {{ old('product_category_id') === $id ? 'selected' : '' }}>{{ $name }}</option>
                @endforeach
              </select>
            </div>

            <div class="form-row">
              <div class="form-group col-6">
                <label for="price">Harga</label>
                <input class="form-control"
                  id="price"
                  name="price"
                  type="number"
                  value="{{ old('price') }}"
                  placeholder="10000"
                  min="0"
                  required>
              </div>
              <div class="form-group col-6">
                <label for="stock">Stock</label>
                <input class="form-control"
                  id="stock"
                  name="stock"
                  type="number"
                  value="{{ old('stock') }}"
                  min="1"
                  placeholder="1"
                  required>
              </div>
            </div>

            <div class="form-row">
              <div class="form-group col-6">
                <label for="weight">Berat</label>
                <input class="form-control"
                  id="weight"
                  name="weight"
                  type="number"
                  value="{{ old('weight') }}"
                  placeholder="Berat dalam angka"
                  required>
              </div>
              <div class="form-group col-6">
                <label for="weight_unit">Satuan Berat</label>
                <select class="form-control select2"
                  id="weight_unit"
                  name="weight_unit">
                  <option value="g"
                    selected>Gram</option>
                  <option value="kg">Kilo Gram</option>
                </select>
              </div>
            </div>

            <div class="form-group">
              <label for="description">Deskripsi</label>
              <textarea class="form-control summernote"
                id="description"
                name="description">{{ old('description') }}</textarea>
            </div>

            <div class="form-group"
              id="extra_info_wrapper">
              <label for="extra_info">Extra Info</label>
              <span class="form-text text-muted">
                Informasi tambahan
              </span>
              <div class="d-flex my-2 extra-info-template">
                <div class="col-md-4 pl-0">
                  <input class="form-control"
                    name="extra_keys[]"
                    type="text"
                    placeholder="kualitas">
                </div>
                <div class="col-md-4">
                  <input class="form-control"
                    name="extra_values[]"
                    type="text"
                    placeholder="asli">
                </div>
                <div class="btn-group">
                  <button class="btn btn-flat btn-info btn-add-extra-info"
                    type="button">Add</button>
                  <button class="btn btn-flat btn-danger btn-remove-extra-info"
                    type="button">Remove</button>
                </div>
              </div>
            </div>

            <button class="btn btn-flat btn-primary"
              type="submit">
              <i class="fa fa-save mr-1"></i> Save
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('scripts')
  <script>
    $(function() {
      $('#extra_info_wrapper').on('click', 'button.btn-add-extra-info', function() {
        $($('.extra-info-template').clone().removeClass('.extra-info-template')[0].outerHTML).appendTo(
          '#extra_info_wrapper');
      })

      $('#extra_info_wrapper').on('click', 'button.btn-remove-extra-info', function() {
        if ($('.extra-info-template').length > 1) {
          $(this).parent().parent().remove();
        }
      })
    })
  </script>
@endpush
