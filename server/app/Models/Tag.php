<?php

namespace App\Models;

use App\Models\Traits\Bulkable;

/**
 * App\Models\Tag.
 *
 * @property int                                                         $id
 * @property array                                                       $name
 * @property array                                                       $slug
 * @property string|null                                                 $type
 * @property int|null                                                    $order_column
 * @property \Illuminate\Support\Carbon|null                             $created_at
 * @property \Illuminate\Support\Carbon|null                             $updated_at
 * @property mixed                                                       $translations
 * @property \Illuminate\Database\Eloquent\Collection|\App\Models\Post[] $posts
 * @property int|null                                                    $posts_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\Spatie\Tags\Tag containing($name, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tag newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tag newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Spatie\Tags\Tag ordered($direction = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tag query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Spatie\Tags\Tag withType($type = null)
 * @mixin \Eloquent
 */
class Tag extends \Spatie\Tags\Tag
{
    use Bulkable;

    public function posts()
    {
        return $this->morphedByMany(Post::class, 'taggable');
    }

    /**
     * Localiser le tri par type.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function buildSortQuery()
    {
        return static::query()->whereType($this->type);
    }

    public function toArray()
    {
        $attributes = parent::toArray();

        /*
         * Appliquer les traductions du site dans sa langue par défaut
         */
        foreach ($this->getTranslatableAttributes() as $name) {
            $attributes[$name] = $this->getTranslation($name, $this->getLocale());
        }

        return $attributes;
    }
}
