<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\CommunityEvent;
use App\Models\CommunityMember;
use App\Models\Order;
use App\Models\Product;
use App\Models\StoreBalance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $community = auth()->user()->community;
        abort_if($community === null || $community->store->id === null, 403, 'Anda tidak memiliki komunitas atau toko!');

        $store = $community->store;
        $orders = Order::with('user')
            ->where('store_id', $store->id)
            ->where(function ($query) {
                $query->orWhere('status', Order::STATUS_PROCESSING)
                    ->orWhere('status', Order::STATUS_COMPLETED)
                    ->orWhere('status', Order::STATUS_ON_DELIVERY);
            });
        return view('seller.dashboard', [
            'total_orders' => $orders->count(),
            'total_products' => Product::where('store_id', $store->id)->get()->count(),
            'total_events' => CommunityEvent::where('community_id', $community->id)->get()->count(),
            'total_members' => CommunityMember::where('community_id', $community->id)->get()->count(),
            'store' => $store,
            'balance' => $store->balance,
            'community' => $community,
            'orders' => $orders->latest()->take(5)->get(),
            'balance_histories' => StoreBalance::available()->orderByRaw('date_format(created_at, "Y-m-d") ASC')->pluck('created_at', 'amount')
        ]);
    }
}
