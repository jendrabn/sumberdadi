<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $store_id
 * @property boolean $type
 * @property integer $amount
 * @property string $description
 * @property string $created_at
 * @property string $updated_at
 * @property Store $store
 */
class StoreBalance extends Model
{
    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'integer';

    public const TYPE_COMPLETED = 1;
    public const TYPE_PENDING = 2;
    public const TYPE_WITHDRAW = 3;
    public const TYPE_CANCELLED = -1;

    /**
     * @var array
     */
    protected $fillable = ['store_id', 'type', 'amount', 'description', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function store()
    {
        return $this->belongsTo('App\Models\Store');
    }

    public function getTypeStringAttribute()
    {
        switch ($this->attributes['type']) {
            case 1:
                return 'Completed';

            case 2:
                return 'Pending';

            case 3:
                return 'Withdraw';

            case -1:
                return 'Cancelled';

            default:
                return 'Unknown';
        }
    }

    public function scopeAvailable($q)
    {
        return $q->where('store_id', auth()->user()->community->store->id)
            ->where(function ($query) {
               $query->where('type', self::TYPE_COMPLETED)
                   ->orWhere('type', self::TYPE_WITHDRAW);
            });
    }
}
