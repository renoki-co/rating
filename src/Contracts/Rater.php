<?php

namespace Rennokki\Rating\Contracts;

interface Rater
{
    public function ratings($model = null);

    public function hasRated($model): bool;

    public function rate($model, $rating): bool;

    public function updateRatingFor($model, $rating): bool;

    public function unrate($model): bool;
}
