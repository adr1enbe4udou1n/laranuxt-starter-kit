<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Model;

/**
 * Trait Toggleable.
 *
 * @property $toggleables
 * @mixin Model
 */
trait Toggleable
{
    /**
     * @param $attribute
     *
     * @throws \Exception
     *
     * @return bool
     */
    public function toggle($attribute)
    {
        if (! \in_array($attribute, $this->toggleables, true)) {
            throw new \Exception(__('exceptions.actions.invalid'));
        }

        return $this->update([$attribute => ! $this->attributes[$attribute]]);
    }
}
