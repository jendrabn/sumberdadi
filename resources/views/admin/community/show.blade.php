@extends('layouts.app')

@section('title', $community->name)

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Detail Community: {{$community->name}}</h1>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card profile-widget">
                    <div class="profile-widget-header">
                        <img alt="image" src="{{ $community->logo_url }}" class="rounded-circle profile-widget-picture">
                        <div class="profile-widget-items">
                            <div class="profile-widget-item">
                                <div class="profile-widget-item-label">Members</div>
                                <div class="profile-widget-item-value">{{ $community->members->count() }}</div>
                            </div>
                            <div class="profile-widget-item">
                                <div class="profile-widget-item-label">Products</div>
                                <div class="profile-widget-item-value">{{ $community->store->products->count() }}</div>
                            </div>
                            <div class="profile-widget-item">
                                <div class="profile-widget-item-label">Events</div>
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
                        <div class="btn-group float-right">
                            <a href="{{ route('admin.communities.edit', $community->id) }}" class="btn btn-warning">Edit</a>
                            <button id="btnDeleteCommunity" role="button" class="btn btn-danger">Delete</button>
                        </div>
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
                        <div class="card-header-action">
                            <button id="addMember" role="button" data-toggle="modal" data-target="#addMemberModal" class="btn btn-primary">Add <i class="fa fa-plus"></i></button>
                        </div>
                    </div>

                    <div class="card-body">
                        @include('partials.alerts')
                        <div class="table-responsive">
                            <table class="table table-stripped" id="members">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Full Name</th>
                                    <th>Role</th>
                                    <th>Join Date</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($community->members->sortByDesc('community_role_id') as $member)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td><a href="{{ route('admin.users.show', $member->user->id) }}">{{ $member->user->full_name }}</a></td>
                                        <td>{{ $member->role->name }}</td>
                                        <td>{{ $member->joined_at }}</td>
                                        <td>
                                            <button class="btn btn-md btn-warning btn-edit" data-id="{{ $member->id }}">
                                                Edit <i class="fa fa-edit"></i>
                                            </button>
                                            <button class="btn btn-md btn-outline-danger btn-delete" data-id="{{ $member->id }}">
                                                Delete <i class="fa fa-trash"></i>
                                            </button>
                                        </td>
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

    <form action="{{route('admin.communities.destroy', $community->id)}}" method="POST" id="formDeleteCommunity">
        @csrf
        @method('DELETE')
    </form>

    <div class="modal fade" tabindex="-1" role="dialog" id="memberModal">
        <div class="modal-dialog" role="document">
            <form id="updateForm" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Member Detail</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="full_name">Full Name</label>
                        <input type="text" id="fullname" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label for="role">Role</label>
                        <select name="role" id="role" class="form-control">
                            @foreach($community_roles as $id => $name)
                                <option value="{{$id}}">{{$name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary btn-submit">Save changes</button>
                </div>
            </div>
            </form>
        </div>
    </div>

    <div class="modal fade" tabindex="-1" role="dialog" id="addMemberModal">
        <div class="modal-dialog" role="document">
            <form id="addMemberForm" action="{{route('admin.communities.add_member') }}" method="POST">
                <input type="hidden" name="community_id" value="{{$community->id}}">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Member</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="full_name">User</label>
                            <select name="user_id" id="user_id" class="form-control select2 search-user" style="width: 150px"></select>
                        </div>
                        <div class="form-group">
                            <label for="community_role_id">Role</label>
                            <select name="community_role_id" id="community_role_id" class="form-control select2">
                                @foreach($community_roles as $id => $name)
                                    <option value="{{$id}}">{{$name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer bg-whitesmoke br">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add <i class="fa fa-plus"></i></button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection

@push('javascript')
    <script>
        $(function () {
            $('select.search-user').select2({
               ajax: {
                   delay: 300,
                   url: '{{route('admin.users.search')}}',
                   method: 'POST',
                   placeholder: 'Search a user',
                   minimumLength: 2,
               }
            });
            $('#btnDeleteCommunity').on('click', function () {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Remove'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#formDeleteCommunity').submit();
                    }
                })
            });
            $('#members').on('click', 'button.btn-delete', function () {
                let url = '{{ url('admin/communities/member') }}/' + $(this).data('id')
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Remove'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'DELETE',
                            url: url,
                            data: {
                                id: $(this).data('id')
                            },
                            dataType: 'json'
                        }).then(function () {
                            Swal.fire(
                                'Deleted!',
                                'A member has been removed from the community.',
                                'success'
                            );
                            window.location.reload();
                        })

                    }
                })
            });
            $('#members').on('click', 'button.btn-edit', function () {
                let btn = $(this)
                let url = '{{ url('admin/communities/member') }}/' + $(this).data('id')
                btn.addClass('btn-progress');
                $.ajax({
                    url: url,
                    dataType: 'json'
                }).then(function (data, textStatus) {
                    $('#updateForm').attr('action', url);
                    $('#role').val(data.community_role_id)
                    $('#fullname').val(data.user.full_name)
                    $('#memberModal').modal();
                }).fail(function (jqXHR, textStatus, errorThrown) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        html: errorThrown
                    })
                }).always(function () {
                    btn.removeClass('btn-progress');
                })
            })
            $('#addMemberForm').on('submit', function () {
                $('button[type=submit]').addClass('btn-progress')
            })
            $('#updateForm').on('submit', function () {
                $('.btn-submit').addClass('btn-progress');
                $('#updateForm').submit();
            });
        })
    </script>
@endpush
