<?php

namespace Rennokki\Rating\Test\Models;

use Illuminate\Database\Eloquent\Model;
use Rennokki\Rating\Contracts\Rating;
use Rennokki\Rating\Traits\CanBeRated;
use Rennokki\Rating\Traits\CanRate;

class Page extends Model implements Rating
{
    use CanRate, CanBeRated;

    protected $fillable = [
        'name',
    ];
}
