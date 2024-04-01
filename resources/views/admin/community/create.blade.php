@extends('layouts.admin')

@section('title', 'Create Community')

@section('content_header')
  <div class="row mb-2">
    <div class="col-sm-6">
      <h1 class="m-0">Create Community</h1>
    </div>
  </div>
@endsection

@section('content')
  <div class="card">
    <div class="card-header">
      <h4>Create new Community</h4>
    </div>
    <div class="card-body">
      @include('partials.alerts')
      <form action="{{ route('admin.communities.store') }}"
        method="POST"
        enctype="multipart/form-data">
        @csrf
        <div class="form-group">
          <label for="name">Name</label>
          <input class="form-control"
            id="name"
            name="name"
            type="text"
            value="{{ old('name') }}"
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
            required></select>
          <small class="form-text text-muted">
            User that will handle this community.
          </small>
        </div>

        <div class="form-group">
          <label for="logo">Logo</label>

          <div class="custom-file">
            <input class="custom-file-input"
              id="logo"
              name="image"
              type="file"
              required>
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
                type="number"
                value="{{ old('whatsapp') }}"
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
                type="text"
                value="{{ old('instagram') }}">
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
                type="text"
                value="{{ old('facebook') }}">
            </div>
            <small class="form-text text-muted">Facebook page</small>
          </div>
        </div>

        <div class="form-group">
          <label for="description">Description</label>
          <textarea class="form-control summernote"
            id="description"
            name="description">{{ old('description') }}</textarea>
        </div>

        <div class="form-group">
          <label for="founded_at">Founded At</label>
          <input class="form-control timepicker"
            id="founded_at"
            name="founded_at"
            type="date"
            value="{{ old('founded_at') }}">
        </div>

        <div class="form-group">
          <div class="control-label">Active</div>

          <div class="custom-control custom-switch">
            <input class="custom-control-input"
              id="is_active"
              name="is_active"
              type="checkbox">
            <label class="custom-control-label"
              for="is_active">Activate the Community</label>
          </div>
        </div>

        <button class="btn btn-flat btn-primary"
          type="submit">
          <i class="fa fa-save mr-1"></i> Create
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
