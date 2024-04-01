@extends('layouts.admin')

@section('title', $event->name)

@section('content_header')
  <div class="row mb-2">
    <div class="col-sm-6">
      <h1 class="m-0">Event: {{ $event->name }}</h1>
    </div>
  </div>
@endsection

@section('content')
  <div class="row">
    <div class="col-8">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Detail Event: {{ $event->name }}</h3>
        </div>
        <div class="card-body">
          <div class="row my-2">
            <div class="col-md-2">
              <strong class="text-black-50">Name</strong>
            </div>
            <div class="col-md-10">
              {{ $event->name }}
            </div>
          </div>
          <div class="row my-2">
            <div class="col-md-2">
              <strong class="text-black-50">Community</strong>
            </div>
            <div class="col-md-10">
              <a href="{{ route('admin.communities.show', $event->community->id) }}">{{ $event->community->name }}</a>
            </div>
          </div>
          @if ($event->location)
            <div class="row">
              <div class="col-md-2">
                <strong class="text-black-50">Location</strong>
              </div>
              <div class="col-md-10">
                {{ $event->location }}
              </div>
            </div>
          @endif
          <div class="row my-2">
            <div class="col-md-2">
              <strong class="text-black-50">Started At</strong>
            </div>
            <div class="col-md-10">
              {{ $event->started_at->format('d F Y H:i') }} ({{ $event->started_at->diffForHumans() }})
            </div>
          </div>
          <div class="row my-2">
            <div class="col-md-2">
              <strong class="text-black-50">Ended At</strong>
            </div>
            <div class="col-md-10">
              {{ $event->ended_at->format('d F Y H:i') }} ({{ $event->ended_at->diffForHumans() }})
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
          <div class="float-right">
            <button class="btn btn-flat btn-danger btn-delete-event mr-2"
              data-id="{{ $event->id }}">Delete
            </button>
            <a class="btn btn-flat btn-warning"
              href="{{ route('admin.events.edit', $event->id) }}">
              Edit
            </a>
          </div>
        </div>
      </div>
    </div>
    <div class="col-4">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Banner</h3>
          {{-- <div class="card-header-action">
            <a class="btn btn-icon btn-primary"
              data-collapse="#banner_img"
              href="#"><i class="fas fa-minus"></i></a>
          </div> --}}
        </div>
        <div class="collapse show"
          id="banner_img">
          <div class="card-body">
            <div class="text-center">
              <img class="img-fluid"
                src="{{ $event->banner_url }}"
                alt="{{ $event->name }}'s banner">
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row"
    style="margin-bottom: 10px;">
    <div class="col-lg-12">
      <button class="btn btn-flat btn-primary"
        id="btnAddAttendance"
        data-toggle="modal"
        data-target="#modalAddAttendance"
        role="button">
        <i class="fa fa-plus mr-1"></i> Add
      </button>
    </div>
  </div>

  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Attendees <span class="badge badge-primary">{{ $event->attendees->count() }}</span></h3>
        </div>
        <div class="card-body">
          @include('partials.alerts')

          <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover datatable table-sm"
              id="attendances">
              <thead>
                <tr>
                  <th class="text-center">#</th>
                  <th>Full Name</th>
                  <th>Join Event At</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($event->attendees as $attendee)
                  <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>
                      <a
                        href="{{ route('admin.users.show', $attendee->member->user->id ?? 0) }}">{{ $attendee->member->user->full_name ?? '' }}</a>
                    </td>
                    <td>{{ $attendee->created_at }}</td>
                    <td>
                      <button class="btn btn-xs btn-danger btn-delete"
                        data-id="{{ $attendee->id }}">
                        Delete
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

  <div class="modal fade"
    id="modalAddAttendance"
    role="dialog"
    tabindex="-1">
    <div class="modal-dialog"
      role="document">
      <form id="formAddAttendance"
        action="{{ route('admin.events.add_attendee') }}"
        method="POST">
        <input name="event_id"
          type="hidden"
          value="{{ $event->id }}">
        @csrf
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Add Attendance</h5>
            <button class="close"
              data-dismiss="modal"
              type="button"
              aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label for="community_member_id">User</label>
              <select class="form-control select2 search-user"
                id="community_member_id"
                name="community_member_id"
                style="width: 100%;">
                @foreach ($members as $member)
                  <option value="{{ $member->id }}">{{ $member->user->full_name }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="modal-footer bg-whitesmoke br">
            <button class="btn btn-secondary"
              data-dismiss="modal"
              type="button">Close</button>
            <button class="btn btn-primary"
              type="submit">Add <i class="fa fa-plus"></i></button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <form id="formDeleteAttendee"
    action="{{ route('admin.events.remove_attendee') }}"
    method="POST">
    @method('DELETE')
    @csrf
    <input id="attendee_id"
      name="attendee_id"
      type="hidden">
  </form>

  <form id="formDeleteEvent"
    action="{{ route('admin.events.destroy', $event->id) }}"
    method="POST">
    @method('DELETE')
    @csrf
  </form>

@endsection

@push('scripts')
  <script>
    $(function() {
      $('button.btn-delete-event').on('click', function() {
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
      $('#attendances').on('click', 'button.btn-delete', function() {
        $('#attendee_id').val($(this).data('id'));
        $('#formDeleteAttendee').submit();
      });
      $('#formAddMember').on('submit', function() {
        $('button[type=submit]').addClass('btn-progress')
      })
    })
  </script>
@endpush
