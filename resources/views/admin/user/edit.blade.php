@extends('layouts.admin')

@section('title', 'Edit ' . $user->first_name)

@section('content_header')
  <div class="row mb-2">
    <div class="col-sm-6">
      <h1 class="m-0">Detail User</h1>
    </div>
  </div>
@endsection

@section('content')
  <div class="row">
    <div class="col-lg-8">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">{{ $user->first_name }}'s info</h3>
        </div>
        <div class="card-body">
          @include('partials.error_alert')
          <form action="{{ route('admin.users.update', $user->id) }}"
            method="POST">
            @csrf
            @method('PUT')
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="first_name">First Name</label>
                <input class="form-control"
                  id="first_name"
                  name="first_name"
                  type="text"
                  value="{{ old('fist_name', $user->first_name) }}"
                  autocomplete="name"
                  required>
              </div>

              <div class="form-group col-md-6">
                <label for="last_name">Last Name</label>
                <input class="form-control"
                  id="last_name"
                  name="last_name"
                  type="text"
                  value="{{ old('last_name', $user->last_name) }}">
              </div>
            </div>

            <div class="form-group">
              <label for="email">Email</label>
              <input class="form-control"
                id="email"
                name="email"
                type="email"
                value="{{ old('email', $user->email) }}"
                required>
            </div>

            <div class="form-group">
              <label for="password">Password</label>
              <input class="form-control"
                id="password"
                name="password"
                type="password"
                value="{{ old('password') }}">
            </div>

            <div class="form-group">
              <label for="role">Role</label>
              <select class="form-control select2"
                id="role"
                name="roles[]"
                multiple>
                @foreach ($roles as $id => $role)
                  <option value="{{ $id }}"
                    {{ $user->hasAnyRole($id) ? 'selected' : '' }}>{{ $role }}</option>
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
    </div>
    <div class="col-lg-4">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title"><i class="fa fa-warning"></i> Options</h3>
        </div>
        <div class="card-body">
          <form action="{{ route('admin.users.destroy', $user->id) }}"
            method="POST">
            @csrf
            @method('DELETE')

            <button class="btn btn-danger btn-flat btn-block"
              type="submit"><i class="fa fa-trash"></i> Delete
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
