<?php

namespace App\Http\Controllers;

use App\Models\Community;
use App\Models\CommunityEvent;
use App\Models\CommunityEventAttendee;
use App\Models\CommunityMember;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('frontpages.homepage', [
            'latest_products' => Product::with('category', 'images')->latest()->take(8)->get(),
            'latest_events' => CommunityEvent::where('started_at', '>=', now())->latest()->take(8)->get()
        ]);
    }

    public function show(Community $community)
    {
        return view('frontpages.community.show', [
            'community' => $community,
            'events' => CommunityEvent::where('community_id', $community->id)->latest()->paginate(5, ['*'], 'events'),
            'products' => Product::with('store')->where('store_id', $community->store->id)->latest()->paginate(10, ['*'], 'products'),
        ]);
    }

    public function event(CommunityEvent $event)
    {
        return view('frontpages.community.event', compact('event'));
    }

    public function registerEvent(CommunityEvent $event)
    {
        $user = auth()->user();
        if ($event->can_join) {
            $member = CommunityMember::where(['user_id' => $user->id, 'community_id' => $event->community_id])->firstOr(function () use ($event, $user) {
                return CommunityMember::create([
                    'user_id' => $user->id,
                    'community_id' => $event->community_id,
                    'community_role_id' => 1,
                    'joined_at' => now()
                ]);
            });
            CommunityEventAttendee::where(['community_member_id' => $member->id, 'event_id' => $event->id])->firstOr(function () use ($event, $member) {
                return CommunityEventAttendee::create([
                    'community_member_id' =>  $member->id,
                    'event_id' => $event->id,
                    'is_absent' => 0
                ]);
            });

            return redirect()->back()->withSuccess('Pendaftaran berhasil!');
        }

        return redirect()->back()->withErrors('Pendaftaran Gagal! Event sudah berakhir');
    }
}
