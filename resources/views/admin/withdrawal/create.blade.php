@extends('layouts.admin')

@section('title', 'Pencairan Dana')

@section('content_header')
  <div class="row mb-2">
    <div class="col-sm-6">
      <h1 class="m-0">Ajukan Pengajuan Dana</h1>
    </div>
  </div>
@endsection

@section('content')
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Ajukan Pengajuan Dana</h3>
        </div>
        <div class="card-body">
          @include('partials.alerts')
          <form action="{{ route('seller.withdrawals.store') }}"
            method="POST">
            @csrf
            <p>Saldo yang dapat dicairkan: <strong>@priceIDR($balance - \App\Models\Withdrawal::WITHDRAWAL_FEE)</strong></p>
            <p>Admin Fee: @priceIDR(\App\Models\Withdrawal::WITHDRAWAL_FEE)</p>
            <p>Minimal saldo yang dapat dicairkan: @priceIDR(10000)</p>

            <div class="form-group">
              <label for="account_number">Nomor Rekening</label>
              <input class="form-control"
                id="account_number"
                name="account_number"
                type="text"
                value="{{ old('account_number') }}"
                placeholder="Nomor Rekening"
                required>
            </div>

            <div class="form-group">
              <label for="bank">Bank</label>
              <select class="form-control select2"
                id="bank"
                name="bank">
                <option value="-1">Pilih bank</option>
                <option value="bca"
                  {{ old('bank') === 'bca' ? 'selected' : '' }}>BCA</option>
                <option value="bni"
                  {{ old('bank') === 'bni' ? 'selected' : '' }}>BNI</option>
                <option value="bri"
                  {{ old('bank') === 'bri' ? 'selected' : '' }}>BRI</option>
                <option value="mandiri"
                  {{ old('bank') === 'mandiri' ? 'selected' : '' }}>Mandiri</option>
                <option value="danamon"
                  {{ old('bank') === 'danamon' ? 'selected' : '' }}>Danamon</option>
              </select>
            </div>

            <div class="form-group">
              <label for="amount">Total Dana</label>
              <input class="form-control"
                id="amount"
                name="amount"
                type="number"
                value="{{ old('amount', $balance - \App\Models\Withdrawal::WITHDRAWAL_FEE) }}"
                min="10000"
                max="{{ $balance - \App\Models\Withdrawal::WITHDRAWAL_FEE }}">
            </div>

            <button class="btn btn-flat btn-icon btn-primary"
              type="submit">
              <i class="fa fa-save mr-1"></i> Ajukan Pencairan Dana
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
