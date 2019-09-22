<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Model;

/**
 * Trait Bulkable.
 *
 * @static bulkActions
 * @mixin Model
 */
trait Bulkable
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public static function bulkList()
    {
        $actions = [];

        if (method_exists(\get_called_class(), 'bulkActions')) {
            $actions = static::bulkActions();
        }

        return collect($actions)
            ->map(function ($batch, $key) {
                return __("crud.bulk_actions.$key");
            });
    }

    /**
     * @param $name
     * @param $ids
     *
     * @throws \Exception
     *
     * @return bool
     */
    public static function doBulk($name, $ids)
    {
        /** @var \Illuminate\Database\Eloquent\Builder $builder */
        $builder = static::whereIn('id', $ids);

        if ('destroy' === $name) {
            /*
             * Suppression sur chaque modèle pour le support des event (suppression cascade ou tout autre traitement)
             */
            return $builder->get()->each->delete();
        }

        $bulks = static::bulkActions();

        if (! isset($bulks[$name])) {
            throw new \Exception('exceptions.actions.invalid');
        }

        return $builder->update($bulks[$name] ?? []);
    }
}
