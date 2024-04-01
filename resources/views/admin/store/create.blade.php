@extends('layouts.admin')

@section('title', 'Create Community Store')

@section('content_header')
  <div class="row mb-2">
    <div class="col-sm-6">
      <h1 class="m-0">Create Community Store</h1>
    </div>
  </div>
@endsection

@section('content')
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Create a new community store</h3>
        </div>
        <div class="card-body">
          @include('partials.alerts')
          <form action="{{ route('admin.stores.store') }}"
            enctype="multipart/form-data"
            method="POST">
            @csrf

            <div class="form-group">
              <label for="name">Name</label>
              <input class="form-control"
                id="name"
                name="name"
                type="text"
                value="{{ old('name') }}"
                autocomplete="name"
                placeholder="Store name"
                required>
              <span class="form-text text-muted">
                Store name
              </span>
            </div>

            <div class="form-group">
              <label for="community_id">Community</label>
              <select class="form-control select2"
                id="community_id"
                name="community_id"
                required>
                @foreach ($communities as $id => $community)
                  <option value="{{ $id }}">{{ $community }}</option>
                @endforeach
              </select>
            </div>

            <div class="form-group">
              <label for="store_image">Store Image</label>
              <div class="custom-file">
                <input class="custom-file-input"
                  id="store_image"
                  name="store_image"
                  type="file"
                  required>
                <label class="custom-file-label"
                  for="store_image">Choose file</label>
              </div>
            </div>

            <div class="form-group">
              <label for="address">Address</label>
              <textarea class="form-control"
                id="address"
                name="address">{{ old('address') }}</textarea>
            </div>

            <div class="form-group">
              <label for="province_id">Provinces</label>
              <select class="form-control select2"
                id="province_id"
                name="province_id"
                required></select>
            </div>

            <div class="form-group">
              <label for="city_id">City</label>
              <select class="form-control select2"
                id="city_id"
                name="city_id"
                required></select>
            </div>

            <div class="form-group">
              <label for="phone">Phone/WA</label>
              <input class="form-control"
                name="phone"
                type="tel"
                value="{{ old('phone') }}">
              <small class="form-text text-muted">Starting with 62</small>
            </div>

            <div class="form-group">
              <label for="verified_at">Verified</label>
              <input class="form-control"
                id="verified_at"
                name="verified_at"
                type="datetime-local"
                value="{{ old('verified_at') }}">
            </div>

            <button class="btn btn-flat btn-primary"
              type="submit">
              <i class="fa fa-save mr-1"></i> Create
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
      $('#province_id').select2({
        ajax: {
          delay: 500,
          type: 'GET',
          url: '{{ route('ajax.provinces') }}',
          dataType: 'json',
          processResults: function(data) {
            let results = [];
            $.each(data.results, function(i, v) {
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
          url: function() {
            return '{{ url('ajax/cities') }}/' + $('#province_id').val()
          },
          processResults: function(data) {
            let results = [];
            $.each(data.results, function(i, v) {
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
