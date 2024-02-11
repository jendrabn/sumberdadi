<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $payment_id
 * @property string $phone_number
 * @property string $wallet_type
 * @property string $created_at
 * @property string $updated_at
 * @property Payment $payment
 */
class PaymentEWallet extends Model
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
    protected $fillable = ['payment_id', 'phone_number', 'wallet_type', 'created_at', 'updated_at'];

    protected $table = 'payment_ewallet';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function payment()
    {
        return $this->belongsTo('App\Models\Payment');
    }
}
