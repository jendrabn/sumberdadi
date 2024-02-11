@extends('layouts.app')

@section('title', $store->name)

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Edit Store: {{$store->name}}</h1>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h4>Detail Store: {{$store->name}}</h4>
                        </div>
                        <div class="card-body">
                            @include('partials.alerts')
                            <form action="{{ route('admin.stores.update', $store->slug) }}" enctype="multipart/form-data" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" autocomplete="name" name="name" id="name" placeholder="Store name" class="form-control" value="{{ old('name', $store->name) }}" required>
                                    <span class="form-text text-muted">
                                        Store name
                                    </span>
                                </div>

                                <div class="form-group">
                                    <label for="slug">Slug</label>
                                    <input type="text" class="form-control" name="slug" id="slug" placeholder="Slug" value="{{old('slug', $store->slug)}}" required>
                                </div>

                                <div class="form-group">
                                    <label for="community_id">Community</label>
                                    <select name="community_id" id="community_id" class="form-control select2" disabled>
                                        <option value="{{$store->community->id}}">{{$store->community->name}}</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="store_image">Store Image</label>
                                    <input type="file" name="store_image" id="store_image" class="form-control" value="{{old('store_image', $store->image)}}">
                                </div>

                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <textarea name="address" id="address" class="form-control h-50">{{old('address', $store->address)}}</textarea>
                                </div>

                                <div class="form-group">
                                    <label for="province_id">Provinces</label>
                                    <select name="province_id" id="province_id" class="form-control select2" required></select>
                                </div>

                                <div class="form-group">
                                    <label for="city_id">City</label>
                                    <select name="city_id" id="city_id" class="form-control select2" required></select>
                                </div>

                                <div class="form-group">
                                    <label for="phone">Phone/WA</label>
                                    <input type="tel" class="form-control" id="phone" name="phone" value="{{old('phone', $store->phone)}}">
                                    <small class="form-text text-muted">Starting with 62</small>
                                </div>

                                <div class="form-group">
                                    <label for="verified_at">Verified</label>
                                    <input type="datetime-local" name="verified_at" id="verified_at" value="{{old('verified_at', $store->verified_at->format('Y-m-d\TH:i'))}}" class="form-control">
                                </div>

                                <button type="submit" class="btn btn-md btn-primary">Save <i class="fa fa-save"></i></button>
                                <a href="{{route('admin.stores.show', $store->slug)}}" class="ml-2 btn btn-md btn-info">Details <i class="fa fa-eye"></i></a>
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
            $('#province_id').select2({
                ajax: {
                    delay: 500,
                    type: 'GET',
                    url: '{{route('ajax.provinces')}}',
                    dataType: 'json',
                    processResults: function (data) {
                        let results = [];
                        $.each(data.results, function (i, v) {
                            results.push({
                                id: i,
                                text: v
                            });
                        });

                        return {
                            results
                        }
                    }
                }
            });

            $('#city_id').select2({
                ajax: {
                    delay: 500,
                    type: 'GET',
                    url: function () {
                        return '{{url('ajax/cities')}}/' + $('#province_id').val()
                    },
                    processResults: function (data) {
                        let results = [];
                        $.each(data.results, function (i, v) {
                            results.push({
                                id: i,
                                text: v
                            });
                        });

                        return {
                            results
                        }
                    }
                }
            })
        })
    </script>
@endpush
