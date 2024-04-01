@extends('layouts.admin')

@section('title', 'Edit Community Product')

@section('content_header')
  <div class="row mb-2">
    <div class="col-sm-6">
      <h1 class="m-0">Edit Community Product</h1>
    </div>
  </div>
@endsection

@section('content')
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Product: <strong>{{ $product->name }}</strong></h3>
        </div>
        <div class="card-body">
          @include('partials.alerts')
          <form action="{{ route('admin.products.update', $product->id) }}"
            enctype="multipart/form-data"
            method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
              <label for="name">Product Name</label>
              <input class="form-control"
                id="name"
                name="name"
                type="text"
                value="{{ old('name', $product->name) }}"
                autocomplete="name"
                placeholder="Product name"
                required>
            </div>

            <div class="form-group">
              <label for="store_id">Store</label>
              <select class="form-control select2"
                id="store_id"
                name="store_id"
                disabled>
                <option value="{{ $product->store->id }}"
                  selected>{{ $product->store->name }}</option>
              </select>
            </div>

            <div class="form-group">
              <label for="product_category_id">Category</label>
              <select class="form-control select2"
                id="product_category_id"
                name="product_category_id"
                required>
                @foreach ($categories as $id => $name)
                  <option value="{{ $id }}"
                    {{ old('product_category_id', $product->category->id) === $id ? 'selected' : '' }}>
                    {{ $name }}</option>
                @endforeach
              </select>
            </div>

            <div class="form-row">
              <div class="form-group col-6">
                <label for="address">Price</label>
                <input class="form-control"
                  name="price"
                  type="number"
                  value="{{ old('price', $product->price) }}"
                  required>
                <small class="form-text text-muted">
                  Minimal harga @priceIDR(10000)
                </small>
              </div>
              <div class="form-group col-6">
                <label for="address">Stock</label>
                <input class="form-control"
                  name="stock"
                  type="number"
                  value="{{ old('stock', $product->stock) }}"
                  min="1"
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
                  value="{{ old('weight', $product->weight) }}"
                  placeholder="Berat dalam angka"
                  required>
              </div>
              <div class="form-group col-6">
                <label for="weight_unit">Satuan Berat</label>
                <select class="form-control"
                  id="weight_unit"
                  name="weight_unit">
                  <option value="kg"
                    {{ $product->weight === 'kg' ? 'selected' : '' }}>Kilo Gram</option>
                  <option value="g"
                    {{ $product->weight === 'g' ? 'selected' : '' }}>Gram</option>
                </select>
              </div>
            </div>

            <div class="form-group">
              <label for="description">Description</label>
              <textarea class="form-control summernote"
                id="description"
                name="description"
                cols="30"
                rows="10">{{ old('description', $product->description) }}</textarea>
            </div>

            <div class="form-group"
              id="extra_info_wrapper">
              <label for="extra_info">Extra Info</label>
              <span class="form-text text-muted">
                Informasi tambahan
              </span>
              @if ($product->extra_info)
                @foreach ($product->extra_info as $key => $val)
                  @if (empty($key) && empty($val))
                    @continue
                  @endif
                  <div class="d-flex my-2">
                    <div class="col-md-4">
                      <input class="form-control form-control-sm"
                        name="extra_keys[]"
                        type="text"
                        value="{{ old('extra_keys[' . $key . ']', $key) }}"
                        placeholder="berat">
                    </div>
                    <div class="col-md-4">
                      <input class="form-control form-control-sm"
                        name="extra_values[]"
                        type="text"
                        value="{{ old('extra_values[' . $val . ']', $val) }}"
                        placeholder="1 kg">
                    </div>
                    <div class="btn-group">
                      <button class="btn btn-sm btn-info btn-add-extra-info"
                        type="button">Add <i class="fa fa-plus"></i></button>
                      <button class="btn btn-sm btn-danger btn-remove-extra-info"
                        type="button">Remove <i class="fa fa-times"></i></button>
                    </div>
                  </div>
                @endforeach
              @endif
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
                    type="button">Add
                  </button>
                  <button class="btn btn-flat btn-danger btn-remove-extra-info"
                    type="button">Remove
                  </button>
                </div>
              </div>
            </div>

            <button class="btn btn-flat btn-primary mr-1"
              type="submit">
              <i class="fa fa-save mr-1"></i> Save
            </button>
            <a class="btn btn-flat btn-info mr-1"
              type="button"
              href="{{ route('product.show', [$product->store->slug, $product->slug]) }}"
              role="button">
              <i class="fa fa-eye mr-1"></i> View
            </a>
            <button class="btn btn-flat btn-danger btn-delete"
              type="button"
              role="button">
              <i class="fa fa-trash mr-1"></i> Delete
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Product Images</h3>
        </div>
        <div class="card-body">
          <form class="dropzone"
            action="{{ route('admin.products.upload_image', $product->id) }}"
            enctype="multipart/form-data"
            method="POST">
            @csrf
            <div class="fallback">
              <input name="file"
                type="file"
                multiple />
            </div>
          </form>
        </div>
        <div class="card-footer bg-whitesmoke">
          <button class="btn btn-flat btn-primary btn-save">
            <i class="fa fa-save mr-1"></i> Save & Continue
          </button>
        </div>
      </div>
    </div>
  </div>

  <form class="d-none"
    id="formDelete"
    action="{{ route('admin.products.destroy', $product->id) }}"
    method="POST">
    @csrf
    @method('DELETE')
  </form>
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

      $('button.btn-delete').on('click', function() {
        Swal.fire({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#d33',
          confirmButtonText: 'Delete',
        }).then((result) => {
          if (result.isConfirmed) {
            $('#formDelete').submit();
          }
        })
      })

      let dropzone = new Dropzone('.dropzone', {
        url: '{{ route('admin.products.upload_image', $product->id) }}',
        autoProcessQueue: false,
        addRemoveLinks: true,
        maxFileSize: 3,
        paramName: 'image',
        acceptedFiles: 'image/*',
        removedfile: function(file) {
          let _ref;

          if (!file.id) {
            return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) :
              null;
          }

          $.ajax({
            type: 'DELETE',
            url: '{{ route('admin.products.delete_image', $product->id) }}',
            data: {
              image_id: file.id
            }
          }).then(function() {
            Toast.fire({
              title: 'Image deleted',
              icon: 'success'
            })
            return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) :
              null;
          }).fail(function(jqXHR, textStatus, errorThrown) {
            Toast.fire({
              title: errorThrown,
              icon: 'error'
            })
          });
        },
        init: function() {
          let submitButton = $('button.btn-save')
          let myDropzone = this;

          let files = [
            @foreach ($product->images as $image)
              {
                name: "{{ $image->filename }}",
                size: {{ $image->size }},
                url: '{{ url($image->image_url) }}',
                id: {{ $image->id }}
              }
              @if (!$loop->last)
                ,
              @endif
            @endforeach
          ];

          $.each(files, function(index, file) {
            myDropzone.emit('addedfile', file)
            myDropzone.emit('thumbnail', file, file.url)
          })

          submitButton.on('click', function() {
            myDropzone.processQueue();
          });
          myDropzone.on('addedfile', function(file) {
            if (!file.type.match(/image.*/)) {
              myDropzone.removeFile(file)
              Toast.fire({
                title: 'Invalid image',
                icon: 'error'
              })
            }
          });
          myDropzone.on('complete', function(file) {
            Toast.fire({
              title: 'Image uploaded successfully',
              icon: 'success'
            })
            window.location.reload();
          });
        }
      });
    })
  </script>
@endpush
