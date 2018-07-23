<?php

namespace Rennokki\Rating\Test\Models;

use Illuminate\Database\Eloquent\Model;

class SimplePage extends Model
{
    protected $table = 'pages';
    protected $fillable = [
        'name',
    ];
}
