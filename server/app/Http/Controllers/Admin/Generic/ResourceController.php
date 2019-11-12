<?php

namespace App\Http\Controllers\Admin\Generic;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class ResourceController extends GenericController
{
    /**
     * @param string  $model
     * @param Request $request
     *
     * @throws \Exception
     *
     * @return array
     */
    public function counter(string $model, Request $request)
    {
        $fullname = $this->getModelClassName($model);

        /** @var Builder $query */
        $query = $fullname::query();

        foreach ($request->query() as $key => $value) {
            $query->where($key, $value);
        }

        return [
            'count' => $query->count(),
        ];
    }

    /**
     * @param string $model
     * @param $id
     * @param $attribute
     *
     * @throws \Exception
     */
    public function toggle(string $model, $id, $attribute)
    {
        $this->getModelInstance($model, $id)->toggle($attribute);
    }

    /**
     * @param string $model
     * @param $id
     * @param $direction
     *
     * @throws \Exception
     */
    public function move(string $model, $id, $direction)
    {
        /** @var \Spatie\EloquentSortable\SortableTrait $model */
        $model = $this->getModelInstance($model, $id);

        switch ($direction) {
            case 'up':
                $model->moveOrderUp();
                break;
            case 'down':
                $model->moveOrderDown();
                break;
        }
    }
}
