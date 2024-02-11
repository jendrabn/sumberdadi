<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

/**
 * @property integer $id
 * @property integer $community_id
 * @property string $name
 * @property string $banner
 * @property string $description
 * @property string $location
 * @property int $max_attendees
 * @property Carbon $started_at
 * @property Carbon $ended_at
 * @property string $created_at
 * @property string $updated_at
 * @property Community $community
 * @property CommunityEventAttendee[] $attendees
 */
class CommunityEvent extends Model
{
    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'integer';

    protected $dates = [
        'started_at', 'ended_at'
    ];

    /**
     * @var array
     */
    protected $fillable = ['community_id', 'name', 'banner', 'description', 'location', 'max_attendees', 'started_at', 'ended_at', 'created_at', 'updated_at'];

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
    public function attendees()
    {
        return $this->hasMany('App\Models\CommunityEventAttendee', 'event_id');
    }

    public function setStartedAtAttribute($data)
    {
        $this->attributes['started_at'] = Carbon::parse($data)->toDateTimeString();
    }

    public function setEndedAtAttribute($data)
    {
        $this->attributes['ended_at'] = Carbon::parse($data)->toDateTimeString();
    }

    public function getBannerUrlAttribute()
    {
        if (str_starts_with($this->attributes['banner'], 'http')) {
            return $this->attributes['banner'];
        }

        return Storage::url($this->attributes['banner']);
    }

    public function getCanJoinAttribute()
    {
        if ($this->started_at->isFuture()) {
            return true;
        }

        if ($this->attributes['ended_at']) {
            return now()->isBetween($this->started_at, $this->ended_at);
        }

        return $this->started_at->isBefore(today());
    }

}
