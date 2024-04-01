@extends('layouts.admin')

@section('title', 'Create User')

@section('content_header')
  <div class="row mb-2">
    <div class="col-sm-6">
      <h1 class="m-0">Create User</h1>
    </div>
  </div>
@endsection

@section('content')
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Create new User</h3>
    </div>
    <div class="card-body">
      @include('partials.error_alert')
      <form action="{{ route('admin.users.store') }}"
        method="POST">
        @csrf
        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="first_name">First Name</label>
            <input class="form-control"
              id="first_name"
              name="first_name"
              type="text"
              value="{{ old('fist_name') }}"
              autocomplete="name"
              required>
          </div>

          <div class="form-group col-md-6">
            <label for="last_name">Last Name</label>
            <input class="form-control"
              id="last_name"
              name="last_name"
              type="text"
              value="{{ old('last_name') }}">
          </div>
        </div>

        <div class="form-group">
          <label for="email">Email</label>
          <input class="form-control"
            id="email"
            name="email"
            type="email"
            value="{{ old('email') }}"
            required>
        </div>

        <div class="form-group">
          <label for="password">Password</label>
          <input class="form-control"
            id="password"
            name="password"
            type="password"
            value="{{ old('password') }}"
            required>
        </div>

        <div class="form-group">
          <label for="role">Role</label>
          <select class="form-control select2"
            id="role"
            name="role">
            @foreach ($roles as $id => $role)
              <option value="{{ $id }}">{{ $role }}</option>
            @endforeach
          </select>
        </div>

        <button class="btn btn-flat btn-primary"
          type="submit">
          <i class="fas fa-save mr-1"></i> Save
        </button>

      </form>
    </div>
  </div>
@endsection
