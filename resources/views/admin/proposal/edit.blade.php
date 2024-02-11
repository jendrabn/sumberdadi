@extends('layouts.app')

@section('title', 'Detail Proposal')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Detial Proposal</h1>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h4>Proposal: {{$proposal->name}}</h4>
                        </div>
                        <div class="card-body">
                            @include('partials.alerts')
                            <form action="{{ route('admin.proposals.update', $proposal->id) }}" method="POST">
                                @method('PUT')
                                @csrf
                                <div class="form-group">
                                    <label for="name">Community Name</label>
                                    <input type="text" autocomplete="name" name="name" id="name" class="form-control" value="{{ old('name', $proposal->name) }}" readonly>
                                </div>

                                <div class="form-group">
                                    <label for="user">User</label>
                                    <input type="text" name="name" id="name" class="form-control" value="{{$proposal->user->full_name .' - '. $proposal->user->id}}" readonly>
                                </div>

                                <div class="form-group">
                                    <label for="description">Deskripsi Proposal</label>
                                    <textarea name="description" id="description" rows="10" class="form-control" style="height: 80px" readonly>{{old('description', $proposal->description)}}</textarea>
                                </div>

                                <div class="form-group">
                                    <label for="reject_reason">Alasan penolakan (pesan apabila ditolak)</label>
                                    <textarea name="reject_reason" id="reject_reason" style="height: 50px" class="form-control">{{old('reject_reason', $proposal->reject_reason)}}</textarea>
                                </div>

                                <div class="form-group">
                                    <label for="action">Aksi</label>
                                    <select name="action" id="action" class="form-control">
                                        <option value="-1">Pilih aksi</option>
                                        <option value="accept" {{$proposal->approved_at ? 'selected' : ''}}>Setujui</option>
                                        <option value="reject" {{$proposal->rejected_at ? 'selected' : ''}}>Tolak</option>
                                    </select>
                                </div>

                                <input type="submit" class="btn btn-md btn-primary" value="Simpan">
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h4>Banner & KTP</h4>
                        </div>
                        <div class="card-body">
                            @if($proposal->banner)
                                <div class="text-center">
                                    <img src="{{$proposal->banner_url}}" alt="{{$proposal->name}}'s logo" style="width: 300px; height: 300px">
                                    <small class="text-muted">Banner/Logo</small>
                                </div>
                            @endif
                            <hr>
                            @if($proposal->ktp)
                                <div class="text-center">
                                    <img src="{{$proposal->ktp_url}}" style="width: 150px; height: 150px">
                                    <small class="text-muted">KTP</small>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
