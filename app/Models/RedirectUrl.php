<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RedirectUrl extends Model
{
    protected $fillable = [
        'code',
        'url',
        'hits',
        'title',
        'status',
        'banner_image'
    ];

    protected $casts = [
        'hits' => 'integer',
        'status' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function incrementHits()
    {
        $this->increment('hits');
    }

    public function isActive()
    {
        return $this->status === 'active';
    }
}
