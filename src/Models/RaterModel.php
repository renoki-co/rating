<?php

namespace Rennokki\Rating\Models;

use Illuminate\Database\Eloquent\Model;

class RaterModel extends Model
{
    protected $table = 'ratings';
    protected $fillable = [
        'rateable_id', 'rateable_type',
        'rater_id', 'rater_type',
        'rating',
    ];
    protected $casts = [
        'rating' => 'float',
    ];

    public function rateable()
    {
        return $this->morphTo();
    }

    public function rater()
    {
        return $this->morphTo();
    }
}
