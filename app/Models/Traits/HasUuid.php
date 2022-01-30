<?php

namespace App\Models\Traits;

use Illuminate\Support\Str;

trait HasUuid
{
    protected static function bootHasUuid()
    {
        // parent::boot(); only needed in the model
        static::creating(function ($model) {
            // $model->uuid or $model->{$model->getKeyName()}
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = Str::uuid();
            }
        });
    }
}
