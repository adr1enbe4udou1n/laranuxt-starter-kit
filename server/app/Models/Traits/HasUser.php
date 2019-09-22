<?php

namespace App\Models\Traits;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Trait HasOwner.
 *
 * @property int $user_id
 * @mixin \Illuminate\Database\Eloquent\Model
 */
trait HasUser
{
    public static function bootHasUser()
    {
        static::creating(function (Model $model) {
            /* @var HasUser $model */
            if (! $model->user_id) {
                $model->user_id = auth()->id();
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
