<?php

namespace Rennokki\Rating\Test\Models;

use Rennokki\Rating\Traits\CanRate;
use Rennokki\Rating\Contracts\Rating;
use Rennokki\Rating\Traits\CanBeRated;
use Illuminate\Database\Eloquent\Model;

class Page extends Model implements Rating
{
    use CanRate, CanBeRated;

    protected $fillable = [
        'name',
    ];
}
