<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProposalStoreRequest;
use App\Models\CommunityProposal;
use App\Models\Order;
use App\Models\Shipping;
use App\Models\StoreBalance;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function orders()
    {
        return view('frontpages.account.orders', [
            'orders' => Order::where('user_id', auth()->user()->id)->latest()->get()
        ]);
    }

    /**
     * @param Order $order
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Order $order)
    {
        abort_if($order->user->id !== auth()->user()->id, 403);
        return view('frontpages.account.order_detail', compact('order'));
    }

    public function updateOrder(Order $order)
    {
        abort_if($order->user->id !== auth()->user()->id, 403);

        DB::beginTransaction();
        try {
            $order->update(['status' => Order::STATUS_COMPLETED]);
            $order->shipping->update(['status' => Shipping::STATUS_SHIPPED]);
            $order->store->balances()
                ->where('store_id', $order->store_id)
                ->where('description', 'like', '%#'. $order->id .'%')
                ->where('type', StoreBalance::TYPE_PENDING)
                ->where('amount', $order->total_amount - $order->ppn)
                ->firstOrFail()
                ->update(['type' => StoreBalance::TYPE_COMPLETED]);

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->withErrors($exception->getMessage());
        }

        return redirect()->back()->withSuccess('Pesanan telah selesai, Terima kasih telah memesan di '. config('app.name'));
    }

    public function propose()
    {
        return view('frontpages.community.propose', [
            'proposal' => CommunityProposal::where('user_id', auth()->user()->id)->first()
        ]);
    }

    /**
     * @param ProposalStoreRequest $request
     * @return mixed
     */
    public function storeProposal(ProposalStoreRequest $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('banner_file')) {
            $validated['banner'] = $request->file('banner_file')->store('public/community_logos');
        }

        if ($request->hasFile('ktp_file')) {
            $validated['ktp'] = $request->file('ktp_file')->store('public/ktps');
        }

        $validated['user_id'] = $request->user()->id;

        CommunityProposal::create($validated);

        return redirect()->back()->withSuccess('Pengajuan telah berhasil dikirim, admin akan segera meninjau pengajuan ini.');
    }

    public function overview()
    {
        return view('frontpages.account.overview', [
            'user' => auth()->user()
        ]);
    }
}
