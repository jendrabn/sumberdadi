@extends('layouts.app')

@section('title', 'Edit Community Product')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Edit Produk</h1>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h4>Produk: <strong>{{$product->name}}</strong></h4>
                        </div>
                        <div class="card-body">
                            @include('partials.alerts')
                            <form action="{{ route('seller.products.update', $product->id) }}" enctype="multipart/form-data" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="name">Product Name</label>
                                    <input type="text" autocomplete="name" name="name" id="name" placeholder="Product name" class="form-control" value="{{ old('name', $product->name) }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="store_id">Store</label>
                                    <select name="store_id" id="store_id" class="form-control select2" disabled>
                                        <option value="{{$product->store->id}}" selected>{{$product->store->name}}</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="product_category_id">Category</label>
                                    <select name="product_category_id" id="product_category_id" class="form-control select2" required>
                                        @foreach($categories as $id => $name)
                                            <option value="{{$id}}" {{old('product_category_id', $product->category->id) === $id ? 'selected' : ''}}>{{$name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-6">
                                        <label for="address">Price</label>
                                        <input type="number" name="price" class="form-control" value="{{old('price', $product->price)}}" required>
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="address">Stock</label>
                                        <input type="number" min="1" name="stock" class="form-control" value="{{old('stock', $product->stock)}}" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea name="description" id="description" cols="30" rows="10"
                                              class="form-control summernote">{{old('description', $product->description)}}</textarea>
                                </div>

                                <div class="form-group" id="extra_info_wrapper">
                                    <label for="extra_info">Extra Info</label>
                                    <span class="form-text text-muted">
                                        Informasi tambahan
                                    </span>
				                    @if ($product->extra_info)
                                    @foreach ($product->extra_info as $key => $val)
                                        @if (empty($key) && empty($val)) @continue @endif
                                        <div class="d-flex my-2">
                                            <div class="col-md-4">
                                                <input type="text" name="extra_keys[]" placeholder="berat" value="{{old('extra_keys['.$key.']', $key)}}" class="form-control form-control-sm">
                                            </div>
                                            <div class="col-md-4">
                                                <input type="text" name="extra_values[]" placeholder="1 kg" value="{{old('extra_values['.$val.']', $val)}}" class="form-control form-control-sm">
                                            </div>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-sm btn-info btn-add-extra-info">Add <i class="fa fa-plus"></i></button>
                                                <button type="button" class="btn btn-sm btn-danger btn-remove-extra-info">Remove <i class="fa fa-times"></i></button>
                                            </div>
                                        </div>
                                    @endforeach
				                    @endif
                                    <div class="d-flex my-2 extra-info-template">
                                        <div class="col-md-4">
                                            <input type="text" name="extra_keys[]" placeholder="berat" class="form-control form-control-sm">
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" name="extra_values[]" placeholder="1 kg" class="form-control form-control-sm">
                                        </div>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-sm btn-info btn-add-extra-info">Add <i class="fa fa-plus"></i></button>
                                            <button type="button" class="btn btn-sm btn-danger btn-remove-extra-info">Remove <i class="fa fa-times"></i></button>
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-md btn-primary">Simpan <i class="fa fa-save"></i></button>
                                <a href="{{route('product.show', [$product->store->slug, $product->slug])}}" role="button" type="button" class="btn btn-md btn-outline-info ml-3">Lihat Produk <i class="fa fa-eye"></i></a>
                                <button role="button" type="button" class="btn btn-md btn-outline-danger btn-delete ml-3">Hapus <i class="fa fa-trash"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h4>Product Images</h4>
                        </div>
                        <div class="card-body">
                            <p>Produk minimal memiliki 1 gambar.</p>
                            <form action="{{route('seller.products.upload_image', $product->id)}}" enctype="multipart/form-data" class="dropzone" method="POST">
                                @csrf
                                <div class="fallback">
                                    <input name="file" type="file" multiple />
                                </div>
                            </form>
                        </div>
                        <div class="card-footer bg-whitesmoke">
                            <button class="btn btn-md btn-primary btn-save">Upload Gambar <i class="fa fa-save"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <form action="{{route('seller.products.destroy', $product->id)}}" method="POST" class="d-none" id="formDelete">
        @csrf
        @method('DELETE')
    </form>
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

            $('button.btn-delete').on('click', function () {
                Swal.fire({
                    title: 'Apakah Anda yakin ingin mengahapus?',
                    text: "Anda tidak dapat mengembalikan produk yang telah dihapus!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'Hapus',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#formDelete').submit();
                    }
                })
            })

            let dropzone = new Dropzone('.dropzone', {
                url: '{{route('seller.products.upload_image', $product->id)}}',
                autoProcessQueue: false,
                addRemoveLinks: true,
                maxFileSize: 3,
                paramName: 'image',
                acceptedFiles: 'image/*',
                removedfile: function(file) {
                    let _ref;

                    if (!file.id) {
                        return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : null;
                    }

                    $.ajax({
                        type: 'DELETE',
                        url: '{{route('seller.products.delete_image', $product->id)}}',
                        data: {
                            image_id: file.id
                        }
                    }).then(function () {
                        Toast.fire({
                            title: 'Image deleted',
                            icon: 'success'
                        })
                        return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : null;
                    }).fail(function (jqXHR, textStatus, errorThrown) {
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
                        { name: "{{$image->filename}}", size: {{$image->size}}, url: '{{url($image->image_url)}}', id: {{$image->id}} } @if(!$loop->last) , @endif
                        @endforeach
                    ];

                    $.each(files, function (index, file) {
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
                            title: 'Gambar berhasil diunggah',
                            icon: 'success'
                        })
                        window.location.reload();
                    });
                }
            });
        })
    </script>
@endpush
