<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Community;
use Illuminate\Http\Request;

class CommunityController extends Controller
{
    public function index()
    {
        $community = Community::with(['members', 'store', 'store.orders'])->firstWhere('user_id', auth()->user()->id);
        return view('seller.community.index', compact('community'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\View\View
     */
    public function edit()
    {
        $community = Community::where('user_id', auth()->user()->id)->firstOrFail();
        return view('seller.community.edit', compact('community'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request)
    {
        $validated = $this->validate($request, [
            'name' => ['string', 'max:255', 'required'],
            'image' => ['nullable'],
            'description' => ['nullable', 'string'],
            'whatsapp' => ['nullable', 'numeric', 'starts_with:62', 'max:20'],
            'founded_at' => ['nullable', 'date'],
            'instagram' => ['nullable', 'alpha_dash', 'max:32'],
            'facebook' => ['nullable', 'url'],
        ]);
        $validated['is_active'] = 1;

        $community = Community::where('user_id', auth()->user()->id)->firstOrFail();
        $community->update($validated);

        return redirect()->back()->withSuccess('Perubahan berhasil disimpan.');
    }
}
