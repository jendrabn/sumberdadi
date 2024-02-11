<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $order_id
 * @property string $number
 * @property integer $amount
 * @property string $status
 * @property string $due_date
 * @property string $created_at
 * @property string $updated_at
 * @property Order $order
 */
class Invoice extends Model
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
    protected $fillable = ['order_id', 'number', 'amount', 'status', 'due_date', 'created_at', 'updated_at'];

    public $dates = [
        'due_date', 'created_at', 'updated_at'
    ];

    public const STATUS_PAID = 'PAID';
    public const STATUS_UNPAID = 'UNPAID';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order()
    {
        return $this->belongsTo('App\Models\Order');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function payments()
    {
        return $this->hasMany('App\Models\Payment');
    }
}
