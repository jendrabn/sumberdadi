<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\ProposalDataTable;
use App\Http\Controllers\Controller;
use App\Models\Community;
use App\Models\CommunityProposal;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CommunityProposalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param ProposalDataTable $dataTable
     * @return \Illuminate\Http\Response
     */
    public function index(ProposalDataTable $dataTable)
    {
        return $dataTable->render('admin.proposal.index');
    }

    /**
     * Display the specified resource.
     *
     * @param CommunityProposal $proposal
     * @return \Illuminate\View\View
     */
    public function show(CommunityProposal $proposal)
    {
        return $this->edit($proposal);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param CommunityProposal $proposal
     * @return \Illuminate\View\View
     */
    public function edit(CommunityProposal $proposal)
    {
        return view('admin.proposal.edit', compact('proposal'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param CommunityProposal $proposal
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, CommunityProposal $proposal)
    {
        $this->validate($request, [
            'reject_reason' => 'required_if:action,reject|nullable|string'
        ]);

        DB::beginTransaction();
        $responseMessage = 'Pengajuan telah disetujui dan komunitas baru telah dibuat';
        try {
            if ($request->action === 'accept') {
                $proposal->user->assignRole('seller');
                $proposal->update([
                    'approved_at' => now(),
                ]);
                $community = Community::where('user_id', $proposal->user->id)->firstOr(function () use ($proposal) {
                    return Community::create([
                        'user_id' => $proposal->user->id,
                        'is_active' => 0,
                        'name' => $proposal->name,
                        'logo' => $proposal->banner,
                        'description' => $proposal->description
                    ]);
                });
                Store::where('community_id', $community->id)->firstOr(function () use ($community, $proposal) {
                    return Store::create([
                        'community_id' => $community->id,
                        'name' => $proposal->name,
                        'slug' => Str::slug($proposal->name),
                        'address' => '',
                        'verified_at' => now(),
                        'image' => $proposal->banner,
                        'city_id' => 160, // JEMBER
                        'province_id' => 11
                    ]);
                });
            }

            if ($request->action === 'reject') {
                $proposal->update([
                    'rejected_at' => now(),
                    'reject_reason' => $request->reject_reason,
                ]);

                $responseMessage = 'Pengajuan berhasil ditolak';
            }
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->route('admin.proposals.index')->withErrors($exception->getMessage());
        }

        return redirect()->route('admin.proposals.index')->withSuccess($responseMessage);
    }

}
