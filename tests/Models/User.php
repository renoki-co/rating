<?php

namespace Rennokki\Rating\Test\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Rennokki\Rating\Contracts\Rating;
use Rennokki\Rating\Traits\CanBeRated;
use Rennokki\Rating\Traits\CanRate;

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
