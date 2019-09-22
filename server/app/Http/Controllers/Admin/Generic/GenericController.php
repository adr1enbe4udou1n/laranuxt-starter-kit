<?php

namespace App\Http\Controllers\Admin\Generic;

use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;

class GenericController extends Controller
{
    /**
     * @param string $model
     *
     * @throws \Exception
     *
     * @return string
     */
    protected function getModelClassName(string $model)
    {
        $fullname = 'App\\Models\\'.Str::studly($model);

        if (! class_exists($fullname)) {
            throw new \Exception(__('exceptions.actions.invalid'));
        }

        return $fullname;
    }

    /**
     * @param string $model
     * @param $id
     *
     * @throws \Exception
     *
     * @return Model
     */
    protected function getModelInstance(string $model, $id)
    {
        $fullname = $this->getModelClassName($model);

        /* @var Model $model */
        return $fullname::find($id);
    }
}
