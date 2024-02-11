<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\WithdrawalDataTable;
use App\Http\Controllers\Controller;
use App\Models\StoreBalance;
use App\Models\Withdrawal;
use Illuminate\Http\Request;

class WithdrawController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param WithdrawalDataTable $dataTable
     * @return \Illuminate\Http\Response
     */
    public function index(WithdrawalDataTable $dataTable)
    {
        return $dataTable->render('admin.withdrawal.index');
    }

    public function edit(Withdrawal $withdrawal)
    {
        $fee = Withdrawal::WITHDRAWAL_FEE;
        $balance = $withdrawal->store->balances()
                ->where('type', StoreBalance::TYPE_COMPLETED)
                ->orWhere('type', StoreBalance::TYPE_WITHDRAW)
                ->where('store_id', $withdrawal->store_id)
                ->sum('amount') - $fee;
        return view('admin.withdrawal.edit', compact('withdrawal', 'balance', 'fee'));
    }

    public function update(Request $request, Withdrawal $withdrawal)
    {
        $this->validate($request, [
            'status' => 'required|string|in:'.implode(',', [Withdrawal::STATUS_COMPLETED, Withdrawal::STATUS_PENDING])
        ]);

        $balance = $withdrawal->store->balances()
                ->where('type', StoreBalance::TYPE_COMPLETED)
                ->orWhere('type', StoreBalance::TYPE_WITHDRAW)
                ->where('store_id', $withdrawal->store_id)
                ->sum('amount') - Withdrawal::WITHDRAWAL_FEE;

        if ($balance < 10000 || $balance < $withdrawal->amount) {
            return redirect()->back()->withErrors('Saldo toko tidak mencukupi');
        }

        if ($withdrawal->status === Withdrawal::STATUS_PENDING) {
            $withdrawal->update(['status' => $request->get('status')]);
            StoreBalance::create([
                'store_id' => $withdrawal->store_id,
                'amount' => -($withdrawal->amount + $withdrawal->fee),
                'description' => 'Pencairan Dana #'.$withdrawal->id.' dari '.config('app.name'),
                'type' => StoreBalance::TYPE_WITHDRAW
            ]);
            return redirect()->back()->withSuccess('Pencairan dana telah berhasil, saldo toko telah dikurangi');
        }

        return redirect()->back()->withErrors('Pencairan dana sebelumnya telah selesai!');
    }
}
