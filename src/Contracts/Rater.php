<?php

namespace Rennokki\Rating\Contracts;

interface Rater
{
    public function ratings($model = null);

    public function hasRated($model);

    public function rate($model, $rating);

    public function updateRatingFor($model, $rating);

    public function unrate($model);
}
