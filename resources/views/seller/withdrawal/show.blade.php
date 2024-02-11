@extends('layouts.app')

@section('title', 'Detail Pencarian Dana #'.$withdrawal->id)

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Detail Pencairan Dana #{{$withdrawal->id}}</h1>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h4>Detail Pencarian Dana</h4>
                        </div>
                        <div class="card-body">
                            @include('partials.alerts')
                            <form action="{{ route('seller.withdrawals.store') }}" method="POST">
                                @csrf

                                <div class="form-group">
                                    <label for="account_number">Nomor Rekening</label>
                                    <input type="text" autocomplete="account_number" name="name" id="account_number" placeholder="Nomor Rekening" class="form-control" value="{{ old('account_number', $withdrawal->account_number) }}" required readonly>
                                </div>

                                <div class="form-group">
                                    <label for="bank">Bank</label>
                                    <select name="bank" id="bank" class="form-control select2" readonly disabled>
                                        <option value="-1">Pilih bank</option>
                                        <option value="bca" {{old('bank', $withdrawal->bank) === 'bca' ? 'selected' : ''}}>BCA</option>
                                        <option value="bni" {{old('bank', $withdrawal->bank) === 'bni' ? 'selected' : ''}}>BNI</option>
                                        <option value="bri" {{old('bank', $withdrawal->bank) === 'bri' ? 'selected' : ''}}>BRI</option>
                                        <option value="mandiri" {{old('bank', $withdrawal->bank) === 'mandiri' ? 'selected' : ''}}>Mandiri</option>
                                        <option value="danamon" {{old('bank', $withdrawal->bank) === 'danamon' ? 'selected' : ''}}>Danamon</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="amount">Total Dana</label>
                                    <input type="number" min="10000" max="{{$balance}}" value="{{old('amount', $balance)}}" name="amount" id="amount" class="form-control" readonly>
                                </div>

                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <input type="text" value="{{old('status', $withdrawal->status)}}" name="status" id="status" class="form-control" readonly>
                                </div>

                                <button type="submit" class="btn btn-md btn-icon btn-primary" disabled><i class="fa fa-save"></i> Ajukan Pencairan Dana</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
