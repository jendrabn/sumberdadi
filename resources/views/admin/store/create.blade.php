@extends('layouts.app')

@section('title', 'Create Community Store')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Create Community Store</h1>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h4>Create a new community store</h4>
                        </div>
                        <div class="card-body">
                            @include('partials.alerts')
                            <form action="{{ route('admin.stores.store') }}" enctype="multipart/form-data" method="POST">
                                @csrf

                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" autocomplete="name" name="name" id="name" placeholder="Store name" class="form-control" value="{{ old('name') }}" required>
                                    <span class="form-text text-muted">
                                        Store name
                                    </span>
                                </div>

                                <div class="form-group">
                                    <label for="community_id">Community</label>
                                    <select name="community_id" id="community_id" class="form-control select2" required>
                                        @foreach($communities as $id => $community)
                                            <option value="{{$id}}">{{$community}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="store_image">Store Image</label>
                                    <input type="file" name="store_image" id="store_image" class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <textarea name="address" id="address" class="form-control h-50">{{old('address')}}</textarea>
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
                                    <input type="tel" class="form-control" name="phone" value="{{old('phone')}}">
                                    <small class="form-text text-muted">Starting with 62</small>
                                </div>

                                <div class="form-group">
                                    <label for="verified_at">Verified</label>
                                    <input type="datetime-local" name="verified_at" id="verified_at" value="{{old('verified_at')}}" class="form-control">
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
