<?php

namespace App\Http\Controllers\Seller;

use App\DataTables\Seller\CommunityEventDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Seller\Event\EventStoreRequest;
use App\Http\Requests\Seller\Event\EventUpdateRequest;
use App\Models\Community;
use App\Models\CommunityEvent;
use App\Models\CommunityEventAttendee;
use App\Models\CommunityMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CommunityEventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param CommunityEventDataTable $dataTable
     * @return void
     */
    public function index(CommunityEventDataTable $dataTable)
    {
        return $dataTable->render('seller.event.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('seller.event.create', [
            'communities' => Community::all()->pluck('name', 'id')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param EventStoreRequest $request
     * @return void
     */
    public function store(EventStoreRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data += ['banner' => $request->file('image')->store('public/events')];
        }

        CommunityEvent::create($data);

        return redirect()->route('seller.events.index')->withSuccess('A new event has been added');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\View\View|void
     */
    public function show($id)
    {
        $event = CommunityEvent::with('attendees', 'attendees.member', 'attendees.member.user')->findOrfail($id);

        abort_if($event->community_id !== auth()->user()->community->id, 403);

        $members = CommunityMember::with('user')->where(['community_id' => $event->community->id])->get();
        return view('seller.event.show', compact('event', 'members'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param CommunityEvent $event
     * @return \Illuminate\View\View
     */
    public function edit(CommunityEvent $event)
    {
        return view('seller.event.edit', compact('event'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param EventUpdateRequest $request
     * @param CommunityEvent $event
     * @return \Illuminate\View\View
     */
    public function update(EventUpdateRequest $request, CommunityEvent $event)
    {
        $data = $request->validated();

        abort_if($event->community_id !== auth()->user()->community->id, 403);

        if ($request->hasFile('image')) {
            $data += ['banner' => $request->file('image')->store('public/events')];
            Storage::delete($event->banner);
        }
        $event->update($data);

        return redirect()->back()->withSuccess('Perubahan berhasil disimpan.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param CommunityEvent $event
     * @return void
     * @throws \Exception
     */
    public function destroy(CommunityEvent $event)
    {
        if ($event->community_id === auth()->user()->community->id) {
            $event->delete();
        }

        return redirect()->route('seller.events.index')->withSuccess('Kegiatan berhasil dihapus!');
    }

    public function addAttendee(Request $request)
    {
        $data = $this->validate($request, [
            'event_id' => 'required|numeric|exists:community_events,id',
        ]);

        $event = CommunityEvent::findOrFail($request->event_id);

        abort_if($event->community_id !== auth()->user()->community->id, 403);

        $member = CommunityEventAttendee::where([
            'community_member_id' => $request->get('community_member_id'),
            'event_id' => $request->get('event_id')
        ])->get();
        $currentAttendees = CommunityEventAttendee::where('event_id', $event->id)->count();

        if ($event->max_attendees >= ($currentAttendees + 1)) {
            return redirect()->back()->withErrors(['Total peserta melebihi maksimal kehadiran. Silahkan dirubah terlebih dahulu']);
        }

        if ($member->isEmpty()) {
            CommunityEventAttendee::create($data);
            return redirect()->back()->withSuccess('Member telah ditambahkan ke dalam event!');
        }

        return redirect()->back()->withErrors(['Gagal menambahkan member ke dalam event']);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function removeAttendee(Request $request)
    {
        $this->validate($request, [
            'attendee_id' => 'required|numeric|exists:community_event_attendees,id'
        ]);

        $eventAttendee = CommunityEventAttendee::findOrFail($request->get('attendee_id'));

        abort_if($eventAttendee->event->community_id !== auth()->user()->community->id, 403);

        $eventAttendee->delete();

        return redirect()->back()->withSuccess('Kehadiran telah dihapus');
    }
}
