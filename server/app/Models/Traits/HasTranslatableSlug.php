<?php

namespace App\Models\Traits;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

/**
 * Trait HasSlug.
 *
 * @property $sluggable
 * @mixin \Illuminate\Database\Eloquent\Model
 */
trait HasTranslatableSlug
{
    public static function bootHasTranslatableSlug()
    {
        static::saving(function (Model $model) {
            /* @var \App\Models\Traits\HasTranslatableSlug|\Spatie\Translatable\HasTranslations $model */
            if (! empty($model->slug)) {
                return;
            }

            collect($model->getTranslatedLocales($model->sluggable))
                ->each(function (string $locale) use ($model) {
                    $model->setTranslation('slug', $locale, Str::slug($model->getTranslation($model->sluggable, $locale)));
                });
        });
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @param $slug
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeBySlug(Builder $builder, $slug)
    {
        $locale = app()->getLocale();

        return $builder->where("slug->$locale", '=', $slug);
    }

    /**
     * @param $slug
     *
     * @return self
     */
    public static function findBySlug($slug): self
    {
        return static::bySlug($slug)->firstOrFail();
    }
}
