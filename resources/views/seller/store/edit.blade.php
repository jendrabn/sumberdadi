@extends('layouts.app')

@section('title', $store->name)

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Edit Toko: {{$store->name}}</h1>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h4>Detail Toko: {{$store->name}}</h4>
                        </div>
                        <div class="card-body">
                            @include('partials.alerts')
                            <form action="{{ route('seller.store.update') }}" enctype="multipart/form-data" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="name">Nama Toko</label>
                                    <input type="text" autocomplete="name" name="name" id="name" placeholder="Store name" class="form-control" value="{{ old('name', $store->name) }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="store_image">Gambar Toko</label>
                                    <input type="file" name="store_image" id="store_image" class="form-control" value="{{old('store_image', $store->image)}}">
                                </div>

                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <textarea name="address" id="address" class="form-control h-50">{{old('address', $store->address)}}</textarea>
                                </div>

                                <div class="form-group">
                                    <label for="province_id">Provinsi</label>
                                    <select name="province_id" id="province_id" class="form-control select2" required></select>
                                </div>

                                <div class="form-group">
                                    <label for="city_id">Kota</label>
                                    <select name="city_id" id="city_id" class="form-control select2" required></select>
                                </div>

                                <div class="form-group">
                                    <label for="phone">Nomor HP/WA</label>
                                    <input type="tel" class="form-control" id="phone" name="phone" value="{{old('phone', $store->phone)}}">
                                    <small class="form-text text-muted">Diawali dengan 62</small>
                                </div>

                                <button type="submit" class="btn btn-md btn-primary">Simpan <i class="fa fa-save"></i></button>
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
