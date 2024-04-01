@extends('layouts.admin')

@section('title', $store->name)

@section('content_header')
  <div class="row mb-2">
    <div class="col-sm-6">
      <h1 class="m-0">Edit Store: {{ $store->name }}</h1>
    </div>
  </div>
@endsection

@section('content')
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Detail Store: {{ $store->name }}</h3>
        </div>
        <div class="card-body">
          @include('partials.alerts')
          <form action="{{ route('admin.stores.update', $store->slug) }}"
            enctype="multipart/form-data"
            method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
              <label for="name">Name</label>
              <input class="form-control"
                id="name"
                name="name"
                type="text"
                value="{{ old('name', $store->name) }}"
                autocomplete="name"
                placeholder="Store name"
                required>
              <span class="form-text text-muted">
                Store name
              </span>
            </div>

            <div class="form-group">
              <label for="slug">Slug</label>
              <input class="form-control"
                id="slug"
                name="slug"
                type="text"
                value="{{ old('slug', $store->slug) }}"
                placeholder="Slug"
                required>
            </div>

            <div class="form-group">
              <label for="community_id">Community</label>
              <select class="form-control select2"
                id="community_id"
                name="community_id"
                disabled>
                <option value="{{ $store->community->id }}">{{ $store->community->name }}</option>
              </select>
            </div>

            <div class="form-group">
              <label for="store_image">Store Image</label>
              <div class="custom-file">
                <input class="custom-file-input"
                  id="store_image"
                  name="store_image"
                  type="file"
                  value="{{ old('store_image', $store->image) }}">
                <label class="custom-file-label"
                  for="store_image">Choose file</label>
              </div>
            </div>

            <div class="form-group">
              <label for="address">Address</label>
              <textarea class="form-control"
                id="address"
                name="address">{{ old('address', $store->address) }}</textarea>
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
                id="phone"
                name="phone"
                type="tel"
                value="{{ old('phone', $store->phone) }}">
              <small class="form-text text-muted">Starting with 62</small>
            </div>

            <div class="form-group">
              <label for="verified_at">Verified</label>
              <input class="form-control"
                id="verified_at"
                name="verified_at"
                type="datetime-local"
                value="{{ old('verified_at', $store->verified_at->format('Y-m-d\TH:i')) }}">
            </div>

            <button class="btn btn-flat btn-primary"
              type="submit">
              <i class="fa fa-save mr-1"></i> Save
            </button>
            <a class="ml-2 btn btn-flat btn-info"
              href="{{ route('admin.stores.show', $store->slug) }}">
              <i class="fa fa-eye mr-1"></i> Details
            </a>
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
