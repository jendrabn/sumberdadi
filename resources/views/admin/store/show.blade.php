@extends('layouts.admin')

@section('title', $store->name)

@section('content_header')
  <div class="row mb-2">
    <div class="col-sm-6">
      <h1 class="m-0">Store: {{ $store->name }}</h1>
    </div>
  </div>
@endsection

@section('content')
  <div class="row">
    <div class="col-8">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Detail Store: {{ $store->name }}</h3>
        </div>
        <div class="card-body">
          <div class="row my-2">
            <div class="col-md-2">
              <strong class="text-black-50">Name</strong>
            </div>
            <div class="col-md-10">
              {{ $store->name }}
            </div>
          </div>
          <div class="row my-2">
            <div class="col-md-2">
              <strong class="text-black-50">Community</strong>
            </div>
            <div class="col-md-10">
              <a href="{{ route('admin.communities.show', $store->community->id) }}">{{ $store->community->name }}</a>
            </div>
          </div>
          <div class="row my-2">
            <div class="col-md-2">
              <strong class="text-black-50">Balance</strong>
            </div>
            <div class="col-md-10">
              @priceIDR($store->balance)
            </div>
          </div>
          @if ($store->verified_at)
            <div class="row my-2">
              <div class="col-md-2">
                <strong class="text-black-50">Verified At</strong>
              </div>
              <div class="col-md-10">
                {{ $store->verified_at->format('d F Y H:i A') }}
              </div>
            </div>
          @endif
          @if ($store->phone)
            <div class="row my-2">
              <div class="col-md-2">
                <strong class="text-black-50">Phone</strong>
              </div>
              <div class="col-md-10">
                <a href="https://wa.me/{{ $store->phone }}">WA ({{ $store->phone }}) <i class="fab fa-whatsapp"></i></a>
              </div>
            </div>
          @endif
          <div class="row my-2">
            <div class="col-md-2">
              <strong class="text-black-50">Address</strong>
            </div>
            <div class="col-md-10">
              {{ $store->address }}
            </div>
          </div>
        </div>
        <div class="card-footer bg-whitesmoke">
          <button class="btn btn-flat btn-danger btn-delete-store">
            <i class="fa fa-trash mr-1"></i> Delete
          </button>
          <a class="btn btn-flat btn-warning"
            href="{{ route('admin.stores.edit', $store->slug) }}">
            <i class="fa fa-edit mr-1"></i> Edit
          </a>
        </div>
      </div>
    </div>
    <div class="col-4">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Profile Picture</h3>
        </div>
        <div class="card-body">
          <div class="text-center">
            <img class="img-fluid"
              src="{{ $store->image_url }}"
              alt="{{ $store->name }}'s banner">
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Products <span class="badge badge-primary">{{ $store->products->count() }}</span></h3>
        </div>
        <div class="card-body">

          <div class="mb-3">
            <a class="btn btn-flat btn-primary"
              href="{{ route('admin.products.create') }}">
              <i class="fa fa-plus mr-1"></i> Add
            </a>
          </div>

          @include('partials.alerts')
          <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover datatable table-sm"
              id="products">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Name</th>
                  <th>Category</th>
                  <th>Price</th>
                  <th>Stock</th>
                  <th>Created At</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($store->products as $product)
                  <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td><a href="{{ route('admin.products.show', $product->slug) }}">{{ $product->name }}</a></td>
                    <td>{{ $product->category->name }}</td>
                    <td>@priceIDR($product->price)</td>
                    <td>{{ $product->stock }}</td>
                    <td>{{ $product->created_at }}</td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Balances</h3>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover datatable table-sm"
              id="balances">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Amount</th>
                  <th>Type</th>
                  <th>Description</th>
                  <th>Created At</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($store->balances as $balance)
                  <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>@priceIDR($balance->amount)</td>
                    <td>{{ $balance->type_string }}</td>
                    <td style="word-wrap: break-word">{{ $balance->description }}</td>
                    <td>{{ $balance->created_at }}</td>
                  </tr>
                @endforeach
              </tbody>
              <tfoot>
                <tr class="bg-whitesmoke">
                  <td>Total</td>
                  <td>@priceIDR($store->balance)</td>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

  <form id="formDeleteStore"
    action="{{ route('admin.stores.destroy', $store->slug) }}"
    method="POST">
    @method('DELETE')
    @csrf
  </form>

@endsection

@push('scripts')
  <script>
    $(function() {
      $('button.btn-delete-store').on('click', function() {
        Swal.fire({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#d33',
          confirmButtonText: 'Delete',
        }).then((result) => {
          if (result.isConfirmed) {
            $('#formDeleteStore').submit();
          }
        })
      })
      $('#products').DataTable();
      $('#balances').DataTable();
    })
  </script>
@endpush
