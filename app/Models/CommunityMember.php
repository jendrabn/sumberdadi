<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $user_id
 * @property integer $community_id
 * @property integer $community_role_id
 * @property string $joined_at
 * @property string $created_at
 * @property string $updated_at
 * @property User $user
 * @property Community $community
 * @property CommunityRole $role
 */
class CommunityMember extends Model
{
    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var string[]
     */
    protected $dates = [
        'joined_at'
    ];

    /**
     * @var array
     */
    protected $fillable = ['user_id', 'community_id', 'community_role_id', 'joined_at', 'created_at', 'updated_at'];

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
    public function community()
    {
        return $this->belongsTo('App\Models\Community');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role()
    {
        return $this->belongsTo('App\Models\CommunityRole', 'community_role_id');
    }
}
