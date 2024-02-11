@extends('layouts.app')

@section('title', 'Edit Informasi Komunitas')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Ubah Informasi Komunitas</h1>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Ubah Informasi: {{$community->name}}</h4>
                        </div>
                        <div class="card-body">
                            @include('partials.alerts')
                            <form action="{{ route('seller.community.update') }}" method="POST" enctype="multipart/form-data">
                                @method('PUT')
                                @csrf
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" autocomplete="name" name="name" id="name" class="form-control"
                                           value="{{ old('name', $community->name) }}" required>
                                    <small class="form-text text-muted">
                                        Nama Komunitas
                                    </small>
                                </div>

                                @if($community->logo)
                                    <div class="text-center">
                                        <img src="{{$community->logo_url}}" alt="{{$community->name}}'s logo" class="rounded-circle" style="width: 150px; height: 150px">
                                    </div>
                                @endif

                                <div class="form-group">
                                    <label for="logo">Logo</label>
                                    <input type="file" name="image" id="logo" class="form-control form-input" value="{{$community->logo}}">
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label for="whatsapp">Whatsapp</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">+</div>
                                            </div>
                                            <input type="number" id="whatsapp" maxlength="15" value="{{old('whatsapp', $community->whatsapp)}}" class="form-control">
                                        </div>
                                        <small class="form-text text-muted">Nomor WhatsApp, diawali dengan 62</small>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="instagram">Instagram</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text"><i class="fab fa-instagram"></i></div>
                                            </div>
                                            <input type="text" id="instagram" value="{{old('instagram', $community->instagram)}}" class="form-control">
                                        </div>
                                        <small class="form-text text-muted">Username instagram anda</small>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="facebook">Facebook</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text"><i class="fab fa-facebook"></i></div>
                                            </div>
                                            <input type="text" id="facebook" value="{{old('facebook', $community->facebook)}}" class="form-control">
                                        </div>
                                        <small class="form-text text-muted">Halaman Facebook</small>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea name="description" id="description" class="form-control summernote">{{old('description', $community->description)}}</textarea>
                                </div>

                                <div class="form-group">
                                    <label for="founded_at">Tanggal Komunitas Didirikan</label>
                                    <input type="date" name="founded_at" id="founded_at" value="{{old('founded_at', $community->founded_at)}}" class="form-control timepicker">
                                </div>

                                <input type="hidden" name="is_active" value="1">

                                <input type="submit" class="btn btn-md btn-primary" value="Update">
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
        $(function () {
            $('textarea.summernote').summernote();
            $('select.search-user').select2({
                width: '100%',
                ajax: {
                    delay: 300,
                    url: '{{route('admin.users.search')}}',
                    method: 'POST',
                    placeholder: 'Search a user',
                    minimumLength: 2,
                }
            });
        })
    </script>
@endpush
