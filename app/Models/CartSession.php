<?php


namespace App\Models;


use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;

class CartSession
{
    public $sessionName = 'cart';

    /**
     * Max Weight in Kg
     */
    public const MAXIMUM_WEIGHT_PER_STORE = 30.0 * 1000;

    /** @var Collection */
    protected $items;

    public function __construct()
    {
        $this->items = collect();
    }

    /**
     * @param $session mixed
     * @return CartSession
     */
    public function from($session)
    {
        if (is_array($session)) {
            $this->items = collect($session);
        }

        return $this;
    }

    /**
     * Save the collection into session.
     */
    protected function save()
    {
        Session::put($this->sessionName, $this->items->all());
    }

    /**
     * @param Product $product
     * @param $quantity
     * @return $this
     */
    public function add(Product $product, $quantity)
    {
        $index = $this->findKey($product->id);
        if ($index !== null && $index !== false) {
            $this->update($product, ($this->items->get($index)['quantity'] ?? 0) + $quantity);
        } else {
            $this->items->push(['product' => $product, 'store_id' => $product->store_id, 'product_id' => $product->id, 'quantity' => $quantity, 'price' => $product->price, 'total_price' => $product->price * $quantity]);
            $this->save();
        }

        return $this;
    }

    public function update(Product $product, $quantity)
    {
        $index = $this->findKey($product->id);
        if ($index !== null && $index !== false) {
            $exProduct = $this->items->get($index);
            $exProduct['quantity'] = $quantity;
            $exProduct['total_price'] = $product['price'] * $quantity;
            $this->items = $this->items->replace([$index => $exProduct]);
            $this->save();
        }

        return $this;
    }

    public function remove($productId)
    {
        $this->items->forget($this->findKey($productId));

        $this->save();

        return $this;
    }

    /**
     * @param $productId
     * @return int|null
     */
    protected function findKey($productId)
    {
        if ($this->items->isEmpty()) {
            return null;
        }

        return $this->items->search(function ($item) use ($productId) {
            return $item['product_id'] === $productId;
        });
    }

    public function quantityFrom(Product $product)
    {
        $index = $this->findKey($product->id);
        if ($index !== null && $index !== false) {
            return $this->items->get($index)['quantity'] ?? 0;
        }

        return 0;
    }

    public function stores()
    {
        return $this->items->unique('store_id');
    }

    public function groupByStore()
    {
        return $this->items->groupBy('store_id');
    }

    public function allStores()
    {
        return $this->stores()->map(function ($item) {
            return (object) $item;
        })->toArray();
    }

    public function totalStores()
    {
        return $this->stores()->count();
    }

    public function items()
    {
        return $this->items;
    }

    public function all()
    {
        return $this->items->map(function ($item) {
            return (object) $item;
        })->toArray();
    }

    public function ppn()
    {
        return $this->subTotal() * 0.1;
    }

    public function ppnAsIDR()
    {
        return $this->asIDR($this->ppn());
    }

    public function subTotal()
    {
        return $this->items->sum(function ($item) {
            return $item['total_price'];
        });
    }

    public function subTotalAsIDR()
    {
        return $this->asIDR($this->subTotal());
    }

    public function grandTotal()
    {
        return $this->subTotal() + $this->ppn();
    }

    public function grandTotalAsIDR()
    {
        return $this->asIDR($this->grandTotal());
    }

    public function asIDR($number)
    {
        return 'Rp. '.number_format($number, 0, ',','.');
    }

    protected function calculateWeight($items)
    {
        return $items->reduce(function ($carry, $item) {
            $item = (object) $item;
            if ($item->product->weight_unit === 'kg') {
                $carry += $item->product->weight * 1000 * $item->quantity;
            } elseif ($item->product->weight_unit === 'g') {
                $carry += $item->product->weight * $item->quantity;
            }
            return $carry;
        }, 0);
    }

    public function weightFromStore($store_id)
    {
        return $this->calculateWeight($this->items->where('store_id', $store_id));
    }

    public function totalWeight()
    {
        return $this->calculateWeight($this->items);
    }

    public function hasOverWeightItems()
    {
        foreach ($this->items as $item) {
            if ($this->weightFromStore($item['store_id']) > self::MAXIMUM_WEIGHT_PER_STORE) {
                return true;
            }
        }

        return false;
    }

    public function totalWeightStr($weight = null)
    {
        $totalWeight = $weight ?: $this->totalWeight();

        if ($totalWeight >= 1000) {
            $weightInKg = number_format($totalWeight / 1000, 1);
            return $weightInKg.' kg';
        }

        return $totalWeight.' gram';
    }

    public function hasOwnedProduct()
    {
        if (! auth()->check()) {
            return false;
        }

        if (auth()->user()->hasAnyRole('seller')) {
            return $this->items->search(function ($item) {
                return $item['store_id'] === auth()->user()->community->store->id;
            }) !== false;
        }

        return false;
    }

    public function clear()
    {
        $this->items = collect([]);
        session()->forget($this->sessionName);
    }
}
