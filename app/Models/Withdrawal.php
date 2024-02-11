<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $store_id
 * @property integer $amount
 * @property integer $fee
 * @property string $method
 * @property string $status
 * @property string $bank
 * @property string $account_number
 * @property string $created_at
 * @property string $updated_at
 * @property Store $store
 */
class Withdrawal extends Model
{
    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'integer';

    public const STATUS_PENDING = 'PENDING';
    public const STATUS_COMPLETED = 'COMPLETED';
    public const WITHDRAWAL_FEE = 6500;

    /**
     * @var array
     */
    protected $fillable = ['store_id', 'amount', 'fee', 'status', 'bank', 'account_number', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function store()
    {
        return $this->belongsTo('App\Models\Store');
    }

    public function scopePending($q)
    {
        return $q->where('status', self::STATUS_PENDING)->where('store_id', auth()->user()->community->store->id);
    }
}
