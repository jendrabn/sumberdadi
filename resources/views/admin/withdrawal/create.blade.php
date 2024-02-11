@extends('layouts.app')

@section('title', 'Pencairan Dana')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Ajukan Pengajuan Dana</h1>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h4>Ajukan Pengajuan Dana</h4>
                        </div>
                        <div class="card-body">
                            @include('partials.alerts')
                            <form action="{{ route('seller.withdrawals.store') }}" method="POST">
                                @csrf
                                <p>Saldo yang dapat dicairkan: <strong>@priceIDR($balance - \App\Models\Withdrawal::WITHDRAWAL_FEE)</strong></p>
                                <p>Admin Fee: @priceIDR(\App\Models\Withdrawal::WITHDRAWAL_FEE)</p>
                                <p>Minimal saldo yang dapat dicairkan: @priceIDR(10000)</p>

                                <div class="form-group">
                                    <label for="account_number">Nomor Rekening</label>
                                    <input type="text" name="account_number" id="account_number" placeholder="Nomor Rekening" class="form-control" value="{{ old('account_number') }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="bank">Bank</label>
                                    <select name="bank" id="bank" class="form-control select2">
                                        <option value="-1">Pilih bank</option>
                                        <option value="bca" {{old('bank') === 'bca' ? 'selected' : ''}}>BCA</option>
                                        <option value="bni" {{old('bank') === 'bni' ? 'selected' : ''}}>BNI</option>
                                        <option value="bri" {{old('bank') === 'bri' ? 'selected' : ''}}>BRI</option>
                                        <option value="mandiri" {{old('bank') === 'mandiri' ? 'selected' : ''}}>Mandiri</option>
                                        <option value="danamon" {{old('bank') === 'danamon' ? 'selected' : ''}}>Danamon</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="amount">Total Dana</label>
                                    <input type="number" min="10000" max="{{$balance-\App\Models\Withdrawal::WITHDRAWAL_FEE}}" value="{{old('amount', $balance - \App\Models\Withdrawal::WITHDRAWAL_FEE)}}" name="amount" id="amount" class="form-control">
                                </div>

                                <button type="submit" class="btn btn-md btn-icon btn-primary"><i class="fa fa-save"></i> Ajukan Pencairan Dana</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
