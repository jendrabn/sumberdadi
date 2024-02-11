<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\CommunityDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Communities\CommunityStoreRequest;
use App\Http\Requests\Admin\Communities\CommunityUpdateRequest;
use App\Models\Community;
use App\Models\CommunityMember;
use App\Models\CommunityRole;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CommunityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(CommunityDataTable $communityDataTable)
    {
        return $communityDataTable->render('admin.community.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.community.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CommunityStoreRequest $request
     * @return void
     */
    public function store(CommunityStoreRequest $request)
    {
        $data = $request->validated();

        if ($request->file('image')) {
            $path = $request->file('image')->store('public/community_logos');
            $data += ['logo' => $path];
        }

        $community = Community::create($data);
        CommunityMember::create([
            'user_id' => $request->get('user_id'),
            'community_id' => $community->id,
            'community_role_id' => CommunityRole::findOrFail(['name' => 'Pengurus'])->id,
            'joined_at' => now()
        ]);

        return redirect()->route('admin.communities.index')->withSuccess('A new community has been added');
    }

    /**
     * Display the specified resource.
     *
     * @param  Community $community
     * @return \Illuminate\View\View
     */
    public function show(Community $community)
    {
        $community_roles = CommunityRole::all()->pluck('name', 'id');
        return view('admin.community.show', compact('community', 'community_roles'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Community $community
     * @return \Illuminate\View\View
     */
    public function edit(Community $community)
    {
        return view('admin.community.edit', compact('community'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CommunityUpdateRequest $request
     * @param Community $community
     * @return void
     */
    public function update(CommunityUpdateRequest $request, Community $community)
    {
        $data = $request->validated();
        if ($request->get('image') !== $community->logo && $request->hasFile('image')) {
            Storage::delete($community->logo);
            $data += ['logo' => $request->file('image')->store('public/community_logos')];
        }

        $community->update($data);

        return redirect()->back()->withSuccess("The community's information successfully updated");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Community $community
     * @return void
     */
    public function destroy(Community $community)
    {
        $community->delete();

        return redirect()->route('admin.communities.index')->withSuccess('A community has been deleted!');
    }

    /**
     * @param $id
     * @return false|string
     */
    public function ajaxMember($id)
    {
        return response()->json(CommunityMember::with('user')->findOrFail($id));
    }

    public function addMember(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|numeric|exists:users,id',
            'community_id' => 'required|numeric|exists:communities,id',
            'community_role_id' => 'required|numeric|exists:community_roles,id',
        ]) + ['joined_at' => now()];

        $isUserInCurrentCommunity = User::whereHas('communities', function ($q) use ($request) {
                $q->where('community_id', $request->get('community_id'));
            })
            ->find($request->get('user_id'));

        // if user exists in current community
        if ($isUserInCurrentCommunity) {
            return redirect()->back()->withErrors(['User already exists in the current community']);
        }

        CommunityMember::create($data);

        return redirect()->back()->withSuccess('A new member has been added to the community');
    }

    /***
     * @param $id
     * @param Request $request
     * @return false|string
     */
    public function updateMemberRole($id, Request $request)
    {
        CommunityMember::findOrFail($id)->update([
            'community_role_id' => $request->get('role', CommunityRole::firstWhere(['name' => 'Member'])->id ?? 1)
        ]);

        return redirect()->back();
    }

    public function deleteMember($id)
    {
        CommunityMember::findOrFail($id)->delete();

        return response()->json(['code' => 'OK']);
    }
}
