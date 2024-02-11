@extends('layouts.app')

@section('title', $event->name)

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Event: {{$event->name}}</h1>
        </div>
        <div class="row">
            <div class="col-8">
                <div class="card card-primary">
                    <div class="card-header">
                        <h4>Detail Event: {{$event->name}}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row my-2">
                            <div class="col-md-2">
                                <strong class="text-black-50">Name</strong>
                            </div>
                            <div class="col-md-10">
                                {{$event->name}}
                            </div>
                        </div>
                        <div class="row my-2">
                            <div class="col-md-2">
                                <strong class="text-black-50">Community</strong>
                            </div>
                            <div class="col-md-10">
                                <a href="{{route('admin.communities.show', $event->community->id)}}">{{$event->community->name}}</a>
                            </div>
                        </div>
                        @if ($event->location)
                            <div class="row">
                                <div class="col-md-2">
                                    <strong class="text-black-50">Location</strong>
                                </div>
                                <div class="col-md-10">
                                    {{$event->location}}
                                </div>
                            </div>
                        @endif
                        <div class="row my-2">
                            <div class="col-md-2">
                                <strong class="text-black-50">Started At</strong>
                            </div>
                            <div class="col-md-10">
                                {{ $event->started_at->format('d F Y H:i') }} ({{$event->started_at->diffForHumans()}})
                            </div>
                        </div>
                        <div class="row my-2">
                            <div class="col-md-2">
                                <strong class="text-black-50">Ended At</strong>
                            </div>
                            <div class="col-md-10">
                                {{ $event->ended_at->format('d F Y H:i') }} ({{$event->ended_at->diffForHumans()}})
                            </div>
                        </div>
                        <div class="row my-2">
                            <div class="col-md-2">
                                <strong class="text-black-50">Description</strong>
                            </div>
                            <div class="col-md-10">
                                {!! $event->description !!}
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-whitesmoke">
                        <div class="btn-group float-right">
                            <button data-id="{{ $event->id }}" class="btn btn-outline-danger btn-delete-event">Delete <i class="fa fa-trash"></i></button>
                            <a href="{{ route('admin.events.edit', $event->id) }}" class="btn btn-warning">Edit <i class="fa fa-edit"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="card card-warning">
                    <div class="card-header">
                        <h4>Banner</h4>
                        <div class="card-header-action">
                            <a data-collapse="#banner_img" class="btn btn-icon btn-primary" href="#"><i class="fas fa-minus"></i></a>
                        </div>
                    </div>
                    <div class="collapse show" id="banner_img">
                        <div class="card-body">
                            <div class="text-center">
                                <img src="{{$event->banner_url}}" alt="{{$event->name}}'s banner" class="img-fluid">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h4>Attendees <span class="badge badge-primary">{{$event->attendees->count()}}</span></h4>
                        <div class="card-header-action">
                            <button id="btnAddAttendance" role="button" data-toggle="modal"
                                    data-target="#modalAddAttendance" class="btn btn-primary">Add <i
                                    class="fa fa-plus"></i></button>
                        </div>
                    </div>
                    <div class="card-body">
                        @include('partials.alerts')
                        <div class="table-responsive">
                            <table class="table table-stripped table-hover" id="attendances">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Full Name</th>
                                    <th>Join Event At</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($event->attendees as $attendee)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <a href="{{ route('admin.users.show', $attendee->member->user->id ?? 0) }}">{{ $attendee->member->user->full_name ?? '' }}</a>
                                        </td>
                                        <td>{{ $attendee->created_at }}</td>
                                        <td>
                                            <button class="btn btn-outline-danger btn-icon btn-delete" data-id="{{ $attendee->id }}"><i class="fa fa-trash"></i> Delete</button>
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

    <div class="modal fade" tabindex="-1" role="dialog" id="modalAddAttendance">
        <div class="modal-dialog" role="document">
            <form id="formAddAttendance" action="{{route('admin.events.add_attendee') }}" method="POST">
                <input type="hidden" name="event_id" value="{{$event->id}}">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Attendance</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="community_member_id">User</label>
                            <select name="community_member_id" id="community_member_id" class="form-control select2 search-user" style="width: 150px">
                                @foreach ($members as $member)
                                    <option value="{{$member->id}}">{{$member->user->full_name}}</option>
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

    <form action="{{route('admin.events.remove_attendee')}}" id="formDeleteAttendee" method="POST">
        @method('DELETE')
        @csrf
        <input type="hidden" name="attendee_id" id="attendee_id">
    </form>

    <form action="{{route('admin.events.destroy', $event->id)}}" id="formDeleteEvent" method="POST">
        @method('DELETE')
        @csrf
    </form>

@endsection

@push('javascript')
    <script>
        $(function () {
            $('button.btn-delete-event').on('click', function () {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'Delete',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#formDeleteEvent').submit();
                    }
                })
            })
            $('#attendances').on('click', 'button.btn-delete', function () {
                $('#attendee_id').val($(this).data('id'));
                $('#formDeleteAttendee').submit();
            });
            $('#formAddMember').on('submit', function () {
                $('button[type=submit]').addClass('btn-progress')
            })
        })
    </script>
@endpush
