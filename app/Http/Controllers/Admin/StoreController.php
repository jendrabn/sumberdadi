<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\StoreDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Stores\StoreStoreRequest;
use App\Http\Requests\Admin\Stores\StoreUpdateRequest;
use App\Models\Community;
use App\Models\Store;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param StoreDataTable $storeDataTable
     * @return \Illuminate\Http\Response
     */
    public function index(StoreDataTable $storeDataTable)
    {
        return $storeDataTable->render('admin.store.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.store.create', [
            'communities' => Community::all()->pluck('name', 'id')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreStoreRequest $request
     * @return void
     */
    public function store(StoreStoreRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('store_image')) {
            $data['image'] = $request->file('store_image')->store('public/store_profiles');
        }

        $data['slug'] = Str::slug($data['name']);
        Store::create($data);

        return redirect()->route('admin.stores.index')->withSuccess('Store has been created!');
    }

    /**
     * Display the specified resource.
     *
     * @param string $slug
     * @return \Illuminate\View\View
     */
    public function show($slug)
    {
        $store = Store::with(['balances', 'products', 'products.category'])->firstWhere(compact('slug'));
        return view('admin.store.show', compact('store'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Store $store
     * @return \Illuminate\View\View
     */
    public function edit(Store $store)
    {
        return view('admin.store.edit', compact('store'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StoreUpdateRequest $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreUpdateRequest $request, Store $store)
    {
        $data = $request->validated();

        if ($request->hasFile('store_image')) {
            $data['image'] = $request->file('store_image')->store('public/store_profiles');
            Storage::delete($store->image);
        }
        $store->update($data);

        return redirect()->back()->withSuccess('Update successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Store $store
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Store $store)
    {
        $store->delete();

        return redirect()->route('admin.stores.index')->withSuccess('A store has been deleted!');
    }
}
