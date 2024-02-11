<?php

namespace App\Http\Controllers\Seller;

use App\DataTables\Seller\ProductDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Seller\Product\ProductStoreRequest;
use App\Http\Requests\Seller\Product\ProductUpdateRequest;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductImage;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param ProductDataTable $dataTable
     * @return \Illuminate\Http\Response
     */
    public function index(ProductDataTable $dataTable)
    {
        return $dataTable->render('seller.product.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('seller.product.create', [
            'categories' => ProductCategory::all()->pluck('name', 'id'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ProductStoreRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ProductStoreRequest $request)
    {
        $product = Product::create($request->validated());

        return redirect()->route('seller.products.add_image', $product->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        return $this->edit($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        abort_if(auth()->user()->community->store->products()->find(['id' => $id])->isEmpty(), 403);
        $product = Product::with(['images', 'store'])->findOrFail($id);
        $categories = ProductCategory::all()->pluck('name', 'id');

        return view('seller.product.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ProductUpdateRequest $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductUpdateRequest $request, $id)
    {
        abort_if(auth()->user()->community->store->products()->find(['id' => $id])->isEmpty(), 403);
        Product::findOrFail($id)->update($request->validated());

        return redirect()->back()->withSuccess('Perubahan berhasil disimpan!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort_if(auth()->user()->community->store->products()->find(['id' => $id])->isEmpty(), 403);
        Product::findOrFail($id)->delete();

        return redirect()->route('seller.products.index')->withSuccess('Produk telah dihapus!');
    }

    /**
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function addImage(int $id)
    {
        abort_if(auth()->user()->community->store->products()->find(['id' => $id])->isEmpty(), 403);
        $product = Product::with(['store', 'category'])->findOrFail($id);
        return view('seller.product.add_images', compact('product'));
    }

    /**
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadImage(Request $request, int $id)
    {
        abort_if(auth()->user()->community->store->products()->find(['id' => $id])->isEmpty(), 403);
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('public/product_images');
            ProductImage::create([
                'product_id' => $id,
                'path' => $path
            ]);

            return response()->json(['message' => 'OK']);
        }

        return response()->json(['message' => 'Invalid request'], 422);
    }

    public function deleteImage(Request $request, int $id)
    {
        abort_if(auth()->user()->community->store->products()->find(['id' => $id])->isEmpty(), 403);
        $this->validate($request, [
            'image_id' => 'required|numeric|exists:product_images,id'
        ]);

        $image = ProductImage::findOrFail($request->get('image_id'));
        Storage::delete($image->path);
        $image->delete();

        return response()->json(['message' => 'OK'], 204);
    }
}
