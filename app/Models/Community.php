<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

/**
 * @property integer $id
 * @property boolean $is_active
 * @property integer $user_id
 * @property string $name
 * @property string $founder
 * @property string $logo
 * @property string $description
 * @property string $founded_at
 * @property string $created_at
 * @property string $updated_at
 * @property User $user
 * @property CommunityEvent[] $events
 */
class Community extends Model
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
    protected $fillable = ['is_active', 'name', 'user_id', 'logo', 'description', 'instagram', 'facebook', 'whatsapp', 'founded_at', 'created_at', 'updated_at'];

    public $dates = [
        'founded_at'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function events()
    {
        return $this->hasMany('App\Models\CommunityEvent');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function members()
    {
        return $this->hasMany('App\Models\CommunityMember');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function store()
    {
        return $this->hasOne('App\Models\Store');
    }

    public function getLogoUrlAttribute()
    {
        if (str_starts_with($this->attributes['logo'], 'http')) {
            return $this->attributes['logo'];
        }

        return Storage::url($this->attributes['logo']);
    }
}
