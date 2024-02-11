@extends('layouts.app')

@section('title', 'Create User')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Create User</h1>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Create new User</h4>
                        </div>
                        <div class="card-body">
                            @include('partials.error_alert')
                            <form action="{{ route('admin.users.store') }}" method="POST">
                                @csrf
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="first_name">First Name</label>
                                        <input type="text" autocomplete="name" name="first_name" id="first_name" class="form-control" value="{{ old('fist_name') }}" required>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="last_name">Last Name</label>
                                        <input type="text" name="last_name" id="last_name" class="form-control" value="{{ old('last_name') }}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" name="password" id="password" class="form-control" value="{{ old('password') }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="role">Role</label>
                                    <select name="role" id="role" class="form-control">
                                        @foreach($roles as $id => $role)
                                        <option value="{{$id}}">{{$role}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <input type="submit" class="btn btn-md btn-primary" value="Save">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
