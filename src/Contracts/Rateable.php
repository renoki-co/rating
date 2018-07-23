<?php

namespace Rennokki\Rating\Contracts;

interface Rateable
{
    public function raters($model = null);

    public function averageRating();
}
