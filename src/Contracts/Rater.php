<?php

namespace Rennokki\Rating\Contracts;

interface Rater
{
    /**
     * Relationship for models that this model currently rated.
     *
     * @param  null|\Illuminate\Database\Eloquent\Model  $model
     * @return mixed
     */
    public function ratings($model = null);

    /**
     * Check if the current model is rating another model.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return bool
     */
    public function hasRated($model): bool;

    /**
     * Rate a certain model.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  float  $rating
     * @return bool
     */
    public function rate($model, float $rating): bool;

    /**
     * Update the rating for a model.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  float  $newRating
     * @return bool
     */
    public function updateRatingFor($model, $newRating): bool;

    /**
     * Unrate a certain model.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return bool
     */
    public function unrate($model): bool;
}
