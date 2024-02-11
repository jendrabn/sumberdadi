<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\CommunityEventDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Communities\EventStoreRequest;
use App\Http\Requests\Admin\Communities\EventUpdateRequest;
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
        return $dataTable->render('admin.event.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.event.create', [
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

        return redirect()->route('admin.events.index')->withSuccess('A new event has been added');
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
        $members = CommunityMember::with('user')->where(['community_id' => $event->community->id])->get();
        return view('admin.event.show', compact('event', 'members'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param CommunityEvent $event
     * @return \Illuminate\View\View
     */
    public function edit(CommunityEvent $event)
    {
        return view('admin.event.edit', compact('event'));
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

        if ($request->hasFile('image')) {
            $data += ['banner' => $request->file('image')->store('public/events')];
            Storage::delete($event->banner);
        }
        $event->update($data);

        return redirect()->back()->withSuccess('Update successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param CommunityEvent $event
     * @return void
     */
    public function destroy(CommunityEvent $event)
    {
        $event->delete();

        return redirect()->route('admin.events.index')->withSuccess('An event has been deleted!');
    }

    public function addAttendee(Request $request)
    {
        $data = $this->validate($request, [
            'event_id' => 'required|numeric|exists:community_events,id',
            'community_member_id' => 'required|numeric|exists:community_members,id'
        ]);

        $member = CommunityEventAttendee::where([
            'community_member_id' => $request->get('community_member_id'),
            'event_id' => $request->get('event_id')
        ])->get();
        if ($member->isEmpty()) {
            CommunityEventAttendee::create($data);
            return redirect()->back()->withSuccess('Member added to event!');
        }

        return redirect()->back()->withErrors(['Unable to add member to the current event']);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function removeAttendee(Request $request) {
        $this->validate($request, [
            'attendee_id' => 'required|numeric|exists:community_event_attendees,id'
        ]);
        CommunityEventAttendee::findOrFail($request->get('attendee_id'))->delete();

        return redirect()->back()->withSuccess('Attendee has been removed');
    }
}
