@extends('layouts.app')

@section('title', 'Pencairan Dana')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Pencairan Dana</h1>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h4>Form Pencairan Dana</h4>
                        </div>
                        <div class="card-body">
                            @include('partials.alerts')
                            <form action="{{ route('seller.withdrawals.store') }}" method="POST">
                                @csrf
                                <p>Saldo yang dapat dicairkan: <strong>@priceIDR($balance)</strong></p>
                                <p>Admin Fee: @priceIDR($fee)</p>
                                <p>Minimal saldo yang dapat dicairkan: @priceIDR(10000)</p>

                                <div class="form-row">
                                    <div class="form-group col-6">
                                        <label for="account_number">Nomor Rekening</label>
                                        <input type="text" name="account_number" id="account_number" placeholder="Nomor Rekening" class="form-control" value="{{ old('account_number') }}" required>
                                    </div>

                                    <div class="form-group col-6">
                                        <label for="bank">Bank</label>
                                        <select name="bank" id="bank" class="form-control select2">
                                            <option value="-1">Pilih bank</option>
                                            <option value="BCA" {{old('bank') === 'BCA' ? 'selected' : ''}}>BCA</option>
                                            <option value="BRI" {{old('bank') === 'BRI' ? 'selected' : ''}}>BRI</option>
                                            <option value="BNI" {{old('bank') === 'BNI' ? 'selected' : ''}}>BNI</option>
                                            <option value="MANDIRI" {{old('bank') === 'MANDIRI' ? 'selected' : ''}}>MANDIRI</option>
                                            <option value="CIMBNIAGA" {{old('bank') === 'CIMBNIAGA' ? 'selected' : ''}}>CIMB NIAGA</option>
                                            <option value="BANKJATIM" {{old('bank') === 'BANKJATIM' ? 'selected' : ''}}>Bank JATIM</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="amount">Jumlah Dana</label>
                                    <input type="number" step="500" min="10000" max="{{$balance}}" value="{{old('amount', $balance)}}" name="amount" id="amount" class="form-control">
                                    <small class="text-muted">Jumlah Dana yang ingin dicairkan</small>
                                </div>

                                <button type="submit" class="btn btn-md btn-icon btn-primary"><i class="fa fa-money-bill-wave"></i> Kirim Pengajuan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
