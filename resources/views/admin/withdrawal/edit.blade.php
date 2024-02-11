@extends('layouts.app')

@section('title', 'Detail Pencairan Dana')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Detail Pencairan Dana</h1>
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
                            <form action="{{ route('admin.withdrawals.update', $withdrawal->id) }}" method="POST">
                                @csrf @method('PUT')

                                <div class="form-group">
                                    <label for="account_number">Nomor Rekening Tujuan</label>
                                    <input type="text" autocomplete="account_number" name="name" id="account_number" placeholder="Nomor Rekening" class="form-control" value="{{ old('account_number', $withdrawal->account_number) }}" readonly>
                                </div>

                                <div class="form-group">
                                    <label for="bank">Bank Tujuan</label>
                                    <select name="bank" id="bank" class="form-control select2" readonly>
                                        <option value="-1">Pilih bank</option>
                                        <option value="bca" {{old('bank', $withdrawal->bank) === 'bca' ? 'selected' : ''}}>BCA</option>
                                        <option value="bni" {{old('bank', $withdrawal->bank) === 'bni' ? 'selected' : ''}}>BNI</option>
                                        <option value="bri" {{old('bank', $withdrawal->bank) === 'bri' ? 'selected' : ''}}>BRI</option>
                                        <option value="mandiri" {{old('bank', $withdrawal->bank) === 'mandiri' ? 'selected' : ''}}>Mandiri</option>
                                        <option value="danamon" {{old('bank', $withdrawal->bank) === 'danamon' ? 'selected' : ''}}>Danamon</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="amount">Jumlah Transfer</label>
                                    <input type="number" min="10000" max="{{$balance}}" value="{{old('amount', $withdrawal->amount)}}" name="amount" id="amount" class="form-control" readonly>
                                    <small class="form-text text-muted">
                                        Jumlah transfer akan ditambahkan dengan biaya admin senilai @priceIDR($fee)
                                    </small>
                                </div>

                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="-1">Pilih Status</option>
                                        <option value="PENDING" {{old('status', $withdrawal->status) === 'PENDING' ? 'selected' : ''}}>Pending</option>
                                        <option value="COMPLETED" {{old('status', $withdrawal->status) === 'COMPLETED' ? 'selected' : ''}}>Completed</option>
                                    </select>
                                    <small class="text-muted form-text">Sebelum memilih status Completed, pastikan anda sudah mentransfer sejumlah @priceIDR($withdrawal->amount) ke Rekening Toko</small>
                                </div>

                                <button type="submit" class="btn btn-md btn-icon btn-primary"><i class="fa fa-save"></i> Ubah Status</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card card-info">
                        <div class="card-header">
                            <h4>Riwayat Saldo Toko <em>{{$withdrawal->store->name}}</em></h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-stripped" id="balances">
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
                                            <td>{{$loop->iteration}}</td>
                                            <td>@priceIDR($balance->amount)</td>
                                            <td>{{$balance->type_string}}</td>
                                            <td style="word-wrap: break-word">{{$balance->description}}</td>
                                            <td>{{$balance->created_at}}</td>
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
        </div>
    </section>
@endsection

@push('javascript')
    <script>
        $(function() {
            $('#balances').DataTable();
        })
    </script>
@endpush
