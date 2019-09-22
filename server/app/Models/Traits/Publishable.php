<?php

namespace App\Models\Traits;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

/**
 * Trait Publishable.
 *
 * @property string         $status
 * @property \Carbon\Carbon $publication_date
 * @property bool           $is_draft
 * @property bool           $is_scheduled
 * @property bool           $is_published
 *
 * @method static \Illuminate\Database\Eloquent\Builder withInactive()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Website\Post published()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Website\Post scheduled()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Website\Post draft()
 * @mixin \Illuminate\Database\Eloquent\Model
 */
trait Publishable
{
    /**
     * Boot the scope.
     */
    public static function bootPublishable()
    {
        static::saving(function (Model $model) {
            /** @var Publishable $model */
            // Brouillon par defaut
            if (null === $model->status) {
                $model->status = 'draft';
            }

            if ($model->is_draft) {
                return;
            }

            // S'assurer du bon état par rapport à la date de publication
            $now = Carbon::now();

            // Mettre en état planifié si date postérieure
            if ($model->publication_date > $now) {
                $model->status = 'scheduled';

                return;
            }

            // Sinon publié
            $model->status = 'published';

            if (! $model->publication_date) {
                // Mettre la date du jour de publication si aucune date indiquée
                $model->publication_date = $now;
            }
        });
    }

    public function getIsDraftAttribute()
    {
        return 'draft' === $this->status;
    }

    public function getIsPublishedAttribute()
    {
        return 'published' === $this->status;
    }

    public function getIsScheduledAttribute()
    {
        return 'scheduled' === $this->status;
    }

    public function scopeDraft(Builder $builder)
    {
        return $builder->where('status', 'draft');
    }

    public function scopePublished(Builder $builder)
    {
        return $builder->where('status', 'published');
    }

    public function scopeScheduled(Builder $builder)
    {
        return $builder->where('status', 'scheduled');
    }
}
