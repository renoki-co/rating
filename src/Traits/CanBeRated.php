<?php

namespace Rennokki\Rating\Traits;

trait CanBeRated
{
    /**
     * Relationship for models that rated this model.
     *
     * @param  null|\Illuminate\Database\Eloquent\Model  $model
     * @return mixed
     */
    public function raters($model = null)
    {
        $modelClass = $model ? (new $model)->getMorphClass() : $this->getMorphClass();

        return $this->morphToMany($modelClass, 'rateable', 'ratings', 'rateable_id', 'rater_id')
                    ->withTimestamps()
                    ->withPivot('rater_type', 'rating')
                    ->wherePivot('rater_type', $modelClass)
                    ->wherePivot('rateable_type', $this->getMorphClass());
    }

    /**
     * Calculate the average rating of the current model.
     *
     * @param  null|\Illuminate\Database\Eloquent\Model  $model
     * @return float
     */
    public function averageRating($model = null): float
    {
        if ($this->raters($model)->count() === 0) {
            return (float) 0.00;
        }

        return (float) $this->raters($model)->avg('rating');
    }
}
