<?php

namespace App\Http\Controllers\Seller;

use App\DataTables\Seller\WithdrawalDataTable;
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
        return $dataTable->render('seller.withdrawal.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function create()
    {
        $fee = Withdrawal::WITHDRAWAL_FEE;
        $balance = StoreBalance::available()->sum('amount') - $fee;

        if ($balance <= 10000) {
            return redirect()->back()->withErrors('Anda tidak memiliki saldo yang cukup. Saldo anda sekarang Rp. '. $balance);
        }

        if (Withdrawal::pending()->get()->isNotEmpty()) {
            return redirect()->back()->withErrors('Anda masih memiliki pengajuan pencairan yang berstatus PENDING');
        }

        return view('seller.withdrawal.create', compact('balance', 'fee'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $balance = StoreBalance::available()->sum('amount') - Withdrawal::WITHDRAWAL_FEE;
        $validated = $this->validate($request, [
            'amount' => 'required|numeric|max:'.$balance,
            'bank' => 'required|string',
            'account_number' => 'required|numeric',
        ]);
        $validated['status'] = Withdrawal::STATUS_PENDING;
        $validated['fee'] = Withdrawal::WITHDRAWAL_FEE;
        $validated['store_id'] = auth()->user()->community->store->id;

        if (Withdrawal::pending()->get()->isNotEmpty()) {
            return redirect()->route('seller.withdrawals.index')->withErrors('Anda masih memiliki pengajuan pencairan yang berstatus PENDNING');
        }

        Withdrawal::create($validated);

        return redirect()->route('seller.withdrawals.index')->withSuccess('Pencairan dana telah dikirim');
    }

    /**
     * Display the specified resource.
     *
     * @param Withdrawal $withdrawal
     * @return \Illuminate\View\View
     */
    public function show(Withdrawal $withdrawal)
    {
        $balance = StoreBalance::available()->sum('amount');

        return view('seller.withdrawal.show', compact('withdrawal', 'balance'));
    }
}
