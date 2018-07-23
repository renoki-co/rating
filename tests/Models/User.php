<?php

namespace Rennokki\Rating\Test\Models;

use Rennokki\Rating\Traits\CanRate;
use Rennokki\Rating\Contracts\Rating;
use Rennokki\Rating\Traits\CanBeRated;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements Rating
{
    use CanRate, CanBeRated;

    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
}
