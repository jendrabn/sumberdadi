<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductRating;
use App\Models\Store;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $products = Product::with(['store', 'ratings']);
        $header = 'Semua Produk';
        $category = null;

        $products->when($request->has('q'), function ($q) use ($request) {
            return $q->where('name', 'like', '%'.$request->get('q').'%')
                ->orWhere('description', $request->get('name'));
        });

        $products->when($request->has('price_min') && $request->has('price_max'), function ($q) use ($request) {
            return $q->orWhereBetween('price', [
                $request->get('price_min', 5000),
                $request->get('price_max', $request->get('price_min', 10000) + 1000000)
            ]);
        });

        $products->when($request->has('category'), function ($q) use ($request, &$header, &$category) {
            $category = ProductCategory::findOrFail($request->get('category'));
            $header = 'Kategori Produk: '. $category->name;
            return $q->orWhere('product_category_id', $request->get('category'));
        });

        $products->when($request->has('rating'), function ($q) use ($request) {
            return $q->orWhereHas('ratings', function ($q) use ($request) {
                return $q->where('rate', $request->get('rating'));
            });
        });

        $products = $products->latest()->paginate(6);
        return view('frontpages.products', compact('products', 'header', 'category'));
    }

    public function category($id)
    {
        $products = Product::with(['store', 'ratings'])->where('product_category_id', $id)->paginate(5);
        $category = ProductCategory::findOrFail($id);
        $header = $category->name;
        return view('frontpages.products', compact('products', 'id', 'category', 'header'));
    }

    /**
     * @param Store $store
     * @param Product $product
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Store $store, Product $product)
    {
        $alreadyRated = false;
        $hasRelatedOrder = false;

        if (auth()->check()) {
            $alreadyRated = ProductRating::where('user_id', auth()->user()->id)->where('product_id', $product->id)->get()->isNotEmpty();
            $hasRelatedOrder = Order::where('user_id', auth()->user()->id)
                ->where('status', Order::STATUS_COMPLETED)
                ->leftJoin('order_items', 'orders.id', '=', 'order_items.order_id')
                ->where('order_items.product_id', $product->id)
                ->get()->isNotEmpty();
        }

        $relatedStoreProducts = Product::with('images')->where('store_id', $store->id)->orWhere('product_category_id', $product->product_category_id)->take(4)->get();

        return view('frontpages.show_product', compact('product', 'store','hasRelatedOrder', 'alreadyRated', 'relatedStoreProducts'));
    }

    /**
     * @param Request $request
     * @param Product $product
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function rate(Request $request, Product $product)
    {
        $validated = $this->validate($request, [
            'rate' => 'required|numeric|in:1,2,3,4,5',
            'comment' => 'required|string'
        ]);
        $validated += [
            'is_flagged' => 0,
            'user_id' => auth()->user()->id,
            'product_id' => $product->id
        ];

        $alreadyRated = ProductRating::where('user_id', auth()->user()->id)->where('product_id', $product->id)->get()->isNotEmpty();
        if ($alreadyRated) {
            return redirect()->back()->withErrors('Anda sudah pernah me-review produk ini!');
        }

        $hasRelatedOrder = Order::where('user_id', auth()->user()->id)
            ->where('status', Order::STATUS_COMPLETED)
            ->leftJoin('order_items', 'orders.id', '=', 'order_items.order_id')
            ->where('order_items.product_id', $product->id)
            ->get()->isNotEmpty();

        if (!$hasRelatedOrder) {
            return redirect()->back()->withErrors('Review gagal! Anda tidak memesan produk ini');
        }

        ProductRating::create($validated);
        return redirect()->back()->withSuccess('Terima kasih telah me-review produk ini');
    }
}
