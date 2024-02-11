<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $order_id
 * @property integer $user_address_id
 * @property integer $sender_city
 * @property integer $receiver_city
 * @property string $shipper
 * @property string $service
 * @property string $estimated_delivery
 * @property integer $weight
 * @property string $tracking_code
 * @property string $status
 * @property string $created_at
 * @property string $updated_at
 * @property Order $order
 * @property UserAddress $userAddress
 * @property City $sender
 * @property City $receiver
 */
class Shipping extends Model
{
    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'integer';

    public const STATUS_PENDING = 'PENDING';
    public const STATUS_PROCESSING = 'PROCESSING';
    public const STATUS_SHIPPED = 'SHIPPED';

    /**
     * @var array
     */
    protected $fillable = ['order_id', 'user_address_id', 'sender_city', 'receiver_city', 'shipper', 'service', 'estimated_delivery', 'weight', 'tracking_code', 'status', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order()
    {
        return $this->belongsTo('App\Models\Order');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function userAddress()
    {
        return $this->belongsTo('App\Models\UserAddress');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sender()
    {
        return $this->belongsTo(City::class, 'sender_city');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function receiver()
    {
        return $this->belongsTo(City::class, 'receiver_city');
    }
}
