<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

/**
 * @property integer $id
 * @property integer $community_id
 * @property string $name
 * @property string $slug
 * @property string $address
 * @property integer $city_id
 * @property integer $province_id
 * @property string $description
 * @property string $image
 * @property string $verified_at
 * @property string $deleted_at
 * @property string $created_at
 * @property string $updated_at
 * @property Community $community
 * @property Invoice[] $invoices
 * @property Product[] $products
 * @property City $city
 * @property Province $province
 * @property StoreBalance[] $balances
 */
class Store extends Model
{
    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['community_id', 'name', 'slug', 'address', 'city_id', 'province_id', 'phone', 'image', 'verified_at', 'created_at', 'updated_at'];

    public $dates = [
        'verified_at'
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function community()
    {
        return $this->belongsTo('App\Models\Community');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function invoices()
    {
        return $this->hasMany('App\Models\Invoice');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products()
    {
        return $this->hasMany('App\Models\Product');
    }

    public function orders()
    {
        return $this->hasMany('App\Models\Order');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function balances()
    {
        return $this->hasMany('App\Models\StoreBalance');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function city()
    {
        return $this->belongsTo(City::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public function getBalanceAttribute()
    {
        return $this->balances()
            ->where(function ($query) {
                $query->orWhere('store_balances.type', StoreBalance::TYPE_COMPLETED)
                    ->orWhere('store_balances.type', StoreBalance::TYPE_WITHDRAW);
            })
            ->sum('amount');
    }

    public function getImageUrlAttribute()
    {
        if (str_starts_with($this->attributes['image'], 'http')) {
            return $this->attributes['image'];
        }

        return Storage::url($this->attributes['image']);
    }

    public function setVerifiedAtAttribute($data)
    {
        $this->attributes['verified_at'] = Carbon::parse($data)->toDateTimeString();
    }
}
