<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $invoice_id
 * @property string $method
 * @property string $status
 * @property integer $amount
 * @property string $created_at
 * @property string $updated_at
 * @property Order $order
 * @property PaymentBank[] $paymentBanks
 */
class Payment extends Model
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
    protected $fillable = ['invoice_id', 'user_id', 'method', 'amount', 'status', 'created_at', 'updated_at'];

    public const STATUS_PENDING = 'PENDING';
    public const STATUS_CANCELLED = 'CANCELLED';
    public const STATUS_RELEASED = 'RELEASED';

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
    public function invoice()
    {
        return $this->belongsTo('App\Models\Invoice');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function bank()
    {
        return $this->hasOne('App\Models\PaymentBank');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function ewallet()
    {
        return $this->hasOne('App\Models\PaymentEWallet');
    }
}
