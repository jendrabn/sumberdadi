<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Community;
use App\Models\Product;
use App\Models\Store;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'total_admin' => User::role('admin')->count(),
            'total_users' => User::role('user')->count(),
            'total_stores' => Store::count(),
            'total_communities' => Community::count()
        ]);
    }
}
