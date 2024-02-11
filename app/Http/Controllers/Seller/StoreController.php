<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class StoreController extends Controller
{
    public function index()
    {
        $store = Store::where('community_id', auth()->user()->community->id)->firstOrFail();
        return view('seller.store.index', compact('store'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\View\View
     */
    public function edit()
    {
        $store = Store::where('community_id', auth()->user()->community->id)->firstOrFail();
        return view('seller.store.edit', compact('store'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request)
    {
        $validated = $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string'],
            'store_image' => ['nullable', 'image'],
            'phone' => ['required', 'starts_with:62'],
            'verified_at' => ['nullable', 'date_format:Y-m-d\TH:i']
        ]);
        $validated['slug'] = Str::slug($request->get('name'));

        $store = Store::where('community_id', auth()->user()->community->id)->firstOrFail();
        $store->update($validated);

        return redirect()->back()->withSuccess('Perubahan berhasil disimpan');
    }
}
