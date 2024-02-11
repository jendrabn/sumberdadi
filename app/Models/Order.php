<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $user_id
 * @property integer $store_id
 * @property string $status
 * @property integer $shipping_cost
 * @property string $description
 * @property string $paid_at
 * @property string $created_at
 * @property string $updated_at
 * @property Invoice[] $invoices
 * @property OrderItem[] $items
 * @property Payment[] $payments
 * @property Store $store
 * @property Shipping $shipping
 */
class Order extends Model
{
    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'integer';

    public const STATUS_PENDING = 'PENDING';
    public const STATUS_PROCESSING = 'PROCESSING';
    public const STATUS_COMPLETED = 'COMPLETED';
    public const STATUS_ON_DELIVERY = 'ON DELIVERY';
    public const STATUS_CANCELLED = 'CANCELLED';

    /**
     * @var array
     */
    protected $fillable = ['user_id', 'store_id', 'status', 'shipping_cost', 'description', 'confirmed_at', 'created_at', 'updated_at'];

    public $dates = [
        'confirmed_at'
    ];

    protected $appends = [
        'total_amount'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function invoice()
    {
        return $this->HasOne('App\Models\Invoice');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items()
    {
        return $this->hasMany('App\Models\OrderItem');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function shipping()
    {
        return $this->hasOne('App\Models\Shipping');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function store()
    {
        return $this->belongsTo('App\Models\Store');
    }

    public function getTotalAttribute()
    {
        return $this->items->reduce(function ($carry, $item) {
            $carry += $item->price * $item->quantity;
            return $carry;
        }, 0);
    }

    public function getTotalAmountAttribute()
    {
        return $this->getTotalAttribute() + ($this->attributes['shipping_cost'] ?? 0) + $this->getPpnAttribute();
    }

    public function getPpnAttribute()
    {
        return $this->getTotalAttribute() * 0.1;
    }
}
