@extends('layouts.app')

@section('title', 'Add Images')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Add Product Images</h1>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h4>Product Images for {{$product->name}}</h4>
                        </div>
                        <div class="card-body">
                            @include('partials.alerts')
                            <form action="{{route('admin.products.upload_image', $product->id)}}" enctype="multipart/form-data" class="dropzone" method="POST">
                                @csrf
                                <div class="fallback">
                                    <input name="file" type="file" multiple />
                                </div>
                            </form>
                        </div>
                        <div class="card-footer bg-whitesmoke">
                            <button class="btn btn-md btn-primary btn-save">Save & Continue <i class="fa fa-save"></i></button>
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
            $('.dropzone').dropzone({
                url: '{{route('admin.products.upload_image', $product->id)}}',
                autoProcessQueue: false,
                addRemoveLinks: true,
                maxFileSize: 3,
                paramName: 'image',
                acceptedFiles: 'image/*',
                init: function() {
                    let submitButton = $('button.btn-save')
                    let myDropzone = this;
                    submitButton.on('click', function() {
                        myDropzone.processQueue();
                    });
                    myDropzone.on("addedfile", function(file) {
                        if (!file.type.match(/image.*/)) {
                            myDropzone.removeFile(file)
                            Toast.fire({
                                title: 'Invalid image',
                                icon: 'error'
                            })
                        }
                    });
                    myDropzone.on("complete", function(file) {
                        myDropzone.removeFile(file);
                        window.location.href = '{{route('admin.products.show', $product->id)}}';
                    });
                }
            });
        })
    </script>
@endpush
