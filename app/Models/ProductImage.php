<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * @property integer $id
 * @property integer $product_id
 * @property string $path
 * @property string $created_at
 * @property string $updated_at
 * @property Product $product
 */
class ProductImage extends Model
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
    protected $fillable = ['product_id', 'path', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }

    public function getFilenameAttribute()
    {
        if ($this->attributes['path']) {
            return basename($this->attributes['path']);
        }

        return null;
    }

    public function getSizeAttribute()
    {
        if (Storage::exists($this->attributes['path'])) {
            return Storage::size($this->attributes['path']);
        }

        return 0;
    }

    public function getImageUrlAttribute()
    {
        if ($this->attributes['path']) {
            if (Str::startsWith($this->attributes['path'], 'http')) {
                return $this->attributes['path'];
            }

            return Storage::url($this->attributes['path']);
        }

        return null;
    }
}
