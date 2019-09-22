<?php

namespace App\Http\Controllers\Admin\Generic;

use Illuminate\Http\Request;
use App\Models\Contracts\BulkActions;

class BulkController extends GenericController
{
    /**
     * @param string $model
     *
     * @throws \Exception
     *
     * @return array|\Illuminate\Support\Collection
     */
    public function actions(string $model)
    {
        /** @var \App\Models\Traits\Bulkable $fullname */
        $fullname = $this->getModelClassName($model);

        if (in_array(BulkActions::class, class_implements($fullname), true)) {
            return $fullname::bulkList();
        }

        return [];
    }

    /**
     * Actions de modifications en lot.
     *
     * @param string                   $model
     * @param string                   $action
     * @param \Illuminate\Http\Request $request
     *
     * @throws \Exception
     *
     * @return array
     */
    public function process(string $model, string $action, Request $request)
    {
        /** @var \App\Models\Traits\Bulkable $fullname */
        $fullname = $this->getModelClassName($model);

        $fullname::doBulk($action, $request->get('ids'));

        return [
            'message' => __('crud.bulk_actions.success'),
        ];
    }
}
