@extends('layouts.admin')

@section('title', $community->name)

@section('content_header')
  <div class="row mb-2">
    <div class="col-sm-6">
      <h1 class="m-0">Detail Community: {{ $community->name }}</h1>
    </div>
  </div>
@endsection

@section('content')
  <div class="row">
    <div class="col-12">
      <div class="card card-widget widget-user shadow">
        <div class="widget-user-header bg-info">
          <h3 class="widget-user-username text-xl">{{ $community->name }}</h3>
          <h5 class="widget-user-desc text-md font-italic">Founded at {{ $community->founded_at }}</h5>
        </div>
        <div class="widget-user-image">
          <img class="img-circle elevation-2"
            src="{{ $community->logo_url }}"
            alt="Image">
        </div>
        <div class="card-footer">
          <div class="row mb-2">
            <div class="col-sm-4 border-right">
              <div class="description-block">
                <h5 class="description-header">{{ $community->members->count() }}</h5>
                <span class="description-text">Members</span>
              </div>
              <!-- /.description-block -->
            </div>
            <!-- /.col -->
            <div class="col-sm-4 border-right">
              <div class="description-block">
                <h5 class="description-header">{{ $community->store->products->count() }}</h5>
                <span class="description-text">Products</span>
              </div>
              <!-- /.description-block -->
            </div>
            <!-- /.col -->
            <div class="col-sm-4">
              <div class="description-block">
                <h5 class="description-header">{{ $community->events->count() }}</h5>
                <span class="description-text">Events</span>
              </div>
              <!-- /.description-block -->
            </div>
            <!-- /.col -->
          </div>

          <p class="text-center">{!! $community->description !!}</p>

          <div class="d-flex justify-content-between align-items-center">
            <div>
              @if ($community->facebook || $community->whatsapp || $community->instagram)
                <span class="font-weight-light text-sm font-italic mr-1">Social Media:</span>
              @endif
              @if ($community->facebook)
                <a class="btn btn-sm bg-light mr-1 btn-facebook"
                  href="{{ $community->facebook }}">
                  <i class="fab fa-facebook-f"></i>
                </a>
              @endif
              @if ($community->whatsapp)
                <a class="btn btn-sm bg-light mr-1 btn-whatsapp"
                  href="https://wa.me/{{ $community->whatsapp }}">
                  <i class="fab fa-whatsapp"></i>
                </a>
              @endif
              @if ($community->instagram)
                <a class="btn btn-sm bg-light mr-1 btn-instagram"
                  href="https://www.instagram.com/{{ $community->instagram }}">
                  <i class="fab fa-instagram"></i>
                </a>
              @endif
            </div>

            <div>
              <a class="btn btn-flat btn-warning mr-1"
                href="{{ route('admin.communities.edit', $community->id) }}">Edit</a>
              <button class="btn btn-flat btn-danger"
                id="btnDeleteCommunity"
                role="button">
                Delete
              </button>
            </div>
          </div>
        </div>
      </div>
      <!-- /.widget-user -->
    </div>
  </div>

  <div class="row"
    style="margin-bottom: 10px;">
    <div class="col-lg-12">
      <button class="btn btn-flat btn-primary"
        id="addMember"
        data-toggle="modal"
        data-target="#addMemberModal"
        role="button">
        <i class="fa fa-plus mr-1"></i>
        Add
      </button>
    </div>
  </div>

  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Members <span class="badge badge-primary">{{ $community->members->count() }}</span></h3>
        </div>

        <div class="card-body">
          @include('partials.alerts')
          <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover datatable table-sm"
              id="members">
              <thead>
                <tr>
                  <th class="text-center">#</th>
                  <th>Full Name</th>
                  <th>Role</th>
                  <th>Join Date</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($community->members->sortByDesc('community_role_id') as $member)
                  <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td><a href="{{ route('admin.users.show', $member->user->id) }}">{{ $member->user->full_name }}</a>
                    </td>
                    <td>{{ $member->role->name }}</td>
                    <td>{{ $member->joined_at }}</td>
                    <td>
                      <button class="btn btn-xs btn-warning btn-edit"
                        data-id="{{ $member->id }}">
                        Edit
                      </button>
                      <button class="btn btn-xs btn-danger btn-delete"
                        data-id="{{ $member->id }}">
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

  <form id="formDeleteCommunity"
    action="{{ route('admin.communities.destroy', $community->id) }}"
    method="POST">
    @csrf
    @method('DELETE')
  </form>

  <div class="modal fade"
    id="memberModal"
    role="dialog"
    tabindex="-1">
    <div class="modal-dialog"
      role="document">
      <form id="updateForm"
        method="POST">
        @csrf
        @method('PUT')
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Member Detail</h5>
            <button class="close"
              data-dismiss="modal"
              type="button"
              aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label for="full_name">Full Name</label>
              <input class="form-control"
                id="fullname"
                type="text"
                readonly>
            </div>
            <div class="form-group">
              <label for="role">Role</label>
              <select class="form-control select2"
                id="role"
                name="role"
                style="width: 100%;">
                @foreach ($community_roles as $id => $name)
                  <option value="{{ $id }}">{{ $name }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="modal-footer bg-whitesmoke br">
            <button class="btn btn-secondary"
              data-dismiss="modal"
              type="button">Close</button>
            <button class="btn btn-primary btn-submit"
              type="submit">Save changes</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <div class="modal fade"
    id="addMemberModal"
    role="dialog"
    tabindex="-1">
    <div class="modal-dialog"
      role="document">
      <form id="addMemberForm"
        action="{{ route('admin.communities.add_member') }}"
        method="POST">
        <input name="community_id"
          type="hidden"
          value="{{ $community->id }}">
        @csrf
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Add Member</h5>
            <button class="close"
              data-dismiss="modal"
              type="button"
              aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label for="full_name">User</label>
              <select class="form-control select2 search-user"
                id="user_id"
                name="user_id"
                style="width: 100%;"
                style="width: 150px"></select>
            </div>
            <div class="form-group">
              <label for="community_role_id">Role</label>
              <select class="form-control select2"
                id="community_role_id"
                name="community_role_id"
                style="width: 100%;">
                @foreach ($community_roles as $id => $name)
                  <option value="{{ $id }}">{{ $name }}</option>
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

@endsection

@push('scripts')
  <script>
    $(function() {
      $('select.search-user').select2({
        ajax: {
          delay: 300,
          url: '{{ route('admin.users.search') }}',
          method: 'POST',
          placeholder: 'Search a user',
          minimumLength: 2,
        }
      });
      $('#btnDeleteCommunity').on('click', function() {
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
      $('#members').on('click', 'button.btn-delete', function() {
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
            }).then(function() {
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
      $('#members').on('click', 'button.btn-edit', function() {
        let btn = $(this)
        let url = '{{ url('admin/communities/member') }}/' + $(this).data('id')
        btn.addClass('btn-progress');
        $.ajax({
          url: url,
          dataType: 'json'
        }).then(function(data, textStatus) {
          $('#updateForm').attr('action', url);
          $('#role').val(data.community_role_id)
          $('#fullname').val(data.user.full_name)
          $('#memberModal').modal();
        }).fail(function(jqXHR, textStatus, errorThrown) {
          Swal.fire({
            icon: 'error',
            title: 'Error!',
            html: errorThrown
          })
        }).always(function() {
          btn.removeClass('btn-progress');
        })
      })
      $('#addMemberForm').on('submit', function() {
        $('button[type=submit]').addClass('btn-progress')
      })
      $('#updateForm').on('submit', function() {
        $('.btn-submit').addClass('btn-progress');
        $('#updateForm').submit();
      });
    })
  </script>
@endpush
