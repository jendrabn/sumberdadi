@extends('layouts.app')

@section('title', $community->name)

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Komunitas: {{$community->name}}</h1>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card profile-widget">
                    <div class="profile-widget-header">
                        <img alt="image" src="{{ $community->logo_url }}" class="rounded-circle profile-widget-picture">
                        <div class="profile-widget-items">
                            <div class="profile-widget-item">
                                <div class="profile-widget-item-label">Pesanan</div>
                                <div class="profile-widget-item-value">{{ $community->store->orders->count() }}</div>
                            </div>
                            <div class="profile-widget-item">
                                <div class="profile-widget-item-label">Produk</div>
                                <div class="profile-widget-item-value">{{ $community->store->products->count() }}</div>
                            </div>
                            <div class="profile-widget-item">
                                <div class="profile-widget-item-label">Kegiatan</div>
                                <div class="profile-widget-item-value">{{ $community->events->count() }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="profile-widget-description pb-0">
                        <div class="profile-widget-name">{{ $community->name }} <div class="text-muted d-inline font-weight-normal"><div class="slash"></div>
                                {{ $community->founded_at }}</div></div>
                        <p>{!! $community->description !!}</p>
                    </div>
                    <div class="card-footer text-center pt-0">
                        @if ($community->facebook || $community->whatsapp || $community->instagram)
                            <div class="font-weight-bold mb-2 text-small">Social Media</div>
                        @endif
                        @if ($community->facebook)
                            <a href="{{ $community->facebook }}" class="btn btn-social-icon mr-1 btn-facebook">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                        @endif
                        @if ($community->whatsapp)
                            <a href="https://wa.me/{{$community->whatsapp}}" class="btn btn-social-icon mr-1 btn-twitter">
                                <i class="fab fa-whatsapp"></i>
                            </a>
                        @endif
                        @if ($community->instagram)
                            <a href="https://www.instagram.com/{{$community->instagram}}" class="btn btn-social-icon mr-1 btn-instagram">
                                <i class="fab fa-instagram"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h4>Members <span class="badge badge-primary">{{$community->members->count()}}</span></h4>
                    </div>

                    <div class="card-body">
                        @include('partials.alerts')
                        <div class="table-responsive">
                            <table class="table table-stripped" id="members">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Full Name</th>
                                    <th>Join Date</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($community->members->sortByDesc('community_role_id') as $member)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{$member->user->full_name}}</td>
                                        <td>{{ $member->joined_at }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
