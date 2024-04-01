@extends('layouts.app')

@section('title', 'Detail Pencairan Dana')

@section('content_header')
  <div class="row mb-2">
    <div class="col-sm-6">
      <h1 class="m-0">Detail Pencairan Dana</h1>
    </div>
  </div>
@endsection

@section('content')
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Detail Pencarian Dana</h3>
        </div>
        <div class="card-body">
          @include('partials.alerts')
          <form action="{{ route('admin.withdrawals.update', $withdrawal->id) }}"
            method="POST">
            @csrf @method('PUT')

            <div class="form-group">
              <label for="account_number">Nomor Rekening Tujuan</label>
              <input class="form-control"
                id="account_number"
                name="name"
                type="text"
                value="{{ old('account_number', $withdrawal->account_number) }}"
                autocomplete="account_number"
                placeholder="Nomor Rekening"
                readonly>
            </div>

            <div class="form-group">
              <label for="bank">Bank Tujuan</label>
              <select class="form-control select2"
                id="bank"
                name="bank"
                readonly>
                <option value="-1">Pilih bank</option>
                <option value="bca"
                  {{ old('bank', $withdrawal->bank) === 'bca' ? 'selected' : '' }}>BCA</option>
                <option value="bni"
                  {{ old('bank', $withdrawal->bank) === 'bni' ? 'selected' : '' }}>BNI</option>
                <option value="bri"
                  {{ old('bank', $withdrawal->bank) === 'bri' ? 'selected' : '' }}>BRI</option>
                <option value="mandiri"
                  {{ old('bank', $withdrawal->bank) === 'mandiri' ? 'selected' : '' }}>Mandiri</option>
                <option value="danamon"
                  {{ old('bank', $withdrawal->bank) === 'danamon' ? 'selected' : '' }}>Danamon</option>
              </select>
            </div>

            <div class="form-group">
              <label for="amount">Jumlah Transfer</label>
              <input class="form-control"
                id="amount"
                name="amount"
                type="number"
                value="{{ old('amount', $withdrawal->amount) }}"
                min="10000"
                max="{{ $balance }}"
                readonly>
              <small class="form-text text-muted">
                Jumlah transfer akan ditambahkan dengan biaya admin senilai @priceIDR($fee)
              </small>
            </div>

            <div class="form-group">
              <label for="status">Status</label>
              <select class="form-control"
                id="status"
                name="status">
                <option value="-1">Pilih Status</option>
                <option value="PENDING"
                  {{ old('status', $withdrawal->status) === 'PENDING' ? 'selected' : '' }}>Pending</option>
                <option value="COMPLETED"
                  {{ old('status', $withdrawal->status) === 'COMPLETED' ? 'selected' : '' }}>Completed</option>
              </select>
              <small class="text-muted form-text">Sebelum memilih status Completed, pastikan anda sudah mentransfer
                sejumlah @priceIDR($withdrawal->amount) ke Rekening Toko</small>
            </div>

            <button class="btn btn-flat btn-icon btn-primary"
              type="submit">
              <i class="fa fa-save mr-1"></i> Ubah Status
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-12">
      <div class="card card-info">
        <div class="card-header">
          <h3 class="card-title">Riwayat Saldo Toko <em>{{ $withdrawal->store->name }}</em></h3>
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
                @foreach ($withdrawal->store->balances as $balance)
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
                  <td>@priceIDR($withdrawal->store->balance)</td>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('scripts')
  <script>
    $(function() {
      $('#balances').DataTable();
    })
  </script>
@endpush
