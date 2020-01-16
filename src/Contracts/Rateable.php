<?php

namespace Rennokki\Rating\Contracts;

interface Rateable
{
    /**
     * Relationship for models that rated this model.
     *
     * @param  null|\Illuminate\Database\Eloquent\Model  $model
     * @return mixed
     */
    public function raters($model = null);

    /**
     * Calculate the average rating of the current model.
     *
     * @param  null|\Illuminate\Database\Eloquent\Model  $model
     * @return float
     */
    public function averageRating();
}
