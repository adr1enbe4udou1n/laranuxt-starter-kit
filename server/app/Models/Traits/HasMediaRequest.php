<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Model;

/**
 * Trait HasMediaRequest.
 *
 * @mixin \Illuminate\Database\Eloquent\Model
 *
 * @property $mediables
 */
trait HasMediaRequest
{
    /**
     * @var string
     */
    public $mediaRequestPrefix = '';

    public static function bootHasMediaRequest()
    {
        static::saving(function (Model $model) {
            /* @var \App\Models\Traits\HasMediaRequest|\Spatie\MediaLibrary\HasMedia\HasMediaTrait $model */
            foreach ($model->mediables as $attribute => $collection) {
                if (request()->input("{$model->mediaRequestPrefix}{$attribute}_delete")) {
                    $model->clearMediaCollection($collection);
                }

                if ($image = request()->file("{$model->mediaRequestPrefix}{$attribute}_file")) {
                    if ($image->isReadable()) {
                        $model->clearMediaCollection($collection)
                            ->addMedia($image)->toMediaCollection($collection);
                    }
                }
            }
        });
    }
}
