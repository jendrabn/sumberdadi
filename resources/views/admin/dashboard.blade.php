@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content_header')
  <div class="row">
    <div class="col-sm-6">
      <h1>Admin Dashboard</h1>
    </div>
  </div>
@endsection

@section('content')
  <div class="row">
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
      <div class="info-box">
        <span class="info-box-icon bg-primary"><i class="fas fa-user-ninja"></i></span>
        <div class="info-box-content">
          <span class="info-box-text">Total Admin</span>
          <span class="info-box-number">{{ $total_admin }}</span>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
      <div class="info-box">
        <span class="info-box-icon bg-danger"><i class="fas fa-users"></i></span>
        <div class="info-box-content">
          <span class="info-box-text">Total Users</span>
          <span class="info-box-number">{{ $total_users }}</span>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
      <div class="info-box">
        <span class="info-box-icon bg-warning"><i class="fas fa-store"></i></span>
        <div class="info-box-content">
          <span class="info-box-text">Stores</span>
          <span class="info-box-number">{{ $total_stores }}</span>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
      <div class="info-box">
        <span class="info-box-icon bg-success"><i class="fas fa-users-cog"></i></span>
        <div class="info-box-content">
          <span class="info-box-text">Communities</span>
          <span class="info-box-number"> {{ $total_communities }}</span>
        </div>
      </div>
    </div>
  </div>
@endsection
