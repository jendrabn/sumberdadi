<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

/**
 * @property integer $id
 * @property integer $user_id
 * @property string $name
 * @property string $description
 * @property string $banner
 * @property string $ktp
 * @property string $reject_reason
 * @property string $approved_at
 * @property string $rejected_at
 * @property string $created_at
 * @property string $updated_at
 * @property User $user
 */
class CommunityProposal extends Model
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
    protected $fillable = ['user_id', 'name', 'description', 'banner', 'ktp', 'reject_reason', 'approved_at', 'rejected_at', 'created_at', 'updated_at'];

    public $dates = [
        'approved_at', 'rejected_at', 'created_at', 'updated_at'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function getBannerUrlAttribute()
    {
        if ($this->attributes['banner'] && Storage::exists($this->attributes['banner'])) {
            return Storage::url($this->attributes['banner']);
        }

        return null;
    }

    public function getKtpUrlAttribute()
    {
        if ($this->attributes['ktp'] && Storage::exists($this->attributes['ktp'])) {
            return Storage::url($this->attributes['ktp']);
        }

        return null;
    }
}
