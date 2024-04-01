@extends('layouts.admin')

@section('title', 'Edit Community')

@section('content_header')
  <div class="row mb-2">
    <div class="col-sm-6">
      <h1 class="m-0">Edit Community</h1>
    </div>
  </div>
@endsection

@section('content')
  <div class="card">
    <div class="card-header">
      <h4>Edit: {{ $community->name }}</h4>
    </div>
    <div class="card-body">
      @include('partials.alerts')
      <form action="{{ route('admin.communities.update', $community->id) }}"
        method="POST"
        enctype="multipart/form-data">
        @method('PUT')
        @csrf
        <div class="form-group">
          <label for="name">Name</label>
          <input class="form-control"
            id="name"
            name="name"
            type="text"
            value="{{ old('name', $community->name) }}"
            autocomplete="name"
            required>
          <small class="form-text text-muted">
            Community Name
          </small>
        </div>

        <div class="form-group">
          <label for="user_id">Handler</label>
          <select class="form-control select2 search-user"
            id="user_id"
            name="user_id"
            required>
            <option value="{{ $community->user_id }}"
              selected>{{ $community->user->full_name }}</option>
          </select>
          <small class="form-text text-muted">
            User that will handle this community.
          </small>
        </div>

        @if ($community->logo)
          <div class="text-center">
            <img class="rounded-circle"
              src="{{ $community->logo_url }}"
              alt="{{ $community->name }}'s logo"
              style="width: 150px; height: 150px">
          </div>
        @endif

        <div class="form-group">
          <label for="logo">Logo</label>
          <div class="custom-file">
            <input class="custom-file-input"
              id="logo"
              name="image"
              type="file"
              value="{{ $community->logo }}">
            <label class="custom-file-label"
              for="logo">Choose file</label>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group col-md-4">
            <label for="whatsapp">Whatsapp</label>
            <div class="input-group">
              <div class="input-group-prepend">
                <div class="input-group-text">+</div>
              </div>
              <input class="form-control"
                id="whatsapp"
                name="whatsapp"
                type="number"
                value="{{ old('whatsapp', $community->whatsapp) }}"
                maxlength="15">
            </div>
            <small class="form-text text-muted">Starting with 62</small>
          </div>
          <div class="form-group col-md-4">
            <label for="instagram">Instagram</label>
            <div class="input-group">
              <div class="input-group-prepend">
                <div class="input-group-text"><i class="fab fa-instagram"></i></div>
              </div>
              <input class="form-control"
                id="instagram"
                name="instagram"
                type="text"
                value="{{ old('instagram', $community->instagram) }}">
            </div>
            <small class="form-text text-muted">Instagram username</small>
          </div>
          <div class="form-group col-md-4">
            <label for="facebook">Facebook</label>
            <div class="input-group">
              <div class="input-group-prepend">
                <div class="input-group-text"><i class="fab fa-facebook"></i></div>
              </div>
              <input class="form-control"
                id="facebook"
                name="facebook"
                type="text"
                value="{{ old('facebook', $community->facebook) }}">
            </div>
            <small class="form-text text-muted">Facebook page</small>
          </div>
        </div>

        <div class="form-group">
          <label for="description">Description</label>
          <textarea class="form-control summernote"
            id="description"
            name="description">{{ old('description', $community->description) }}</textarea>
        </div>

        <div class="form-group">
          <label for="founded_at">Founded At</label>
          <input class="form-control timepicker"
            id="founded_at"
            name="founded_at"
            type="date"
            value="{{ old('founded_at', $community->founded_at) }}">
        </div>

        <div class="form-group">
          <div class="control-label">Active</div>

          <div class="custom-control custom-switch">
            <input class="custom-control-input"
              id="is_active"
              name="is_active"
              type="checkbox"
              value="{{ old('is_active', $community->is_active) }}"
              {{ old('is_active', $community->is_active) === 1 ? 'checked' : '' }}>
            <label class="custom-control-label"
              for="is_active">Activate the Community</label>
          </div>

        </div>

        <button class="btn btn-flat btn-primary"
          type="submit">
          <i class="fas fa-save mr-1"></i> Update
        </button>
      </form>
    </div>
  </div>
@endsection

@push('scripts')
  <script>
    $(function() {
      $('textarea.summernote').summernote();
      $('select.search-user').select2({
        width: '100%',
        ajax: {
          delay: 300,
          url: '{{ route('admin.users.search') }}',
          method: 'POST',
          placeholder: 'Search a user',
          minimumLength: 2,
        }
      });
    })
  </script>
@endpush
