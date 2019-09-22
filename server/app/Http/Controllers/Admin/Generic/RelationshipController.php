<?php

namespace App\Http\Controllers\Admin\Generic;

class RelationshipController extends GenericController
{
    /**
     * @param $model
     * @param $id
     * @param $relation
     *
     * @throws \Exception
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    private function getBelongToRelation($model, $id, $relation)
    {
        $model = $this->getModelInstance($model, $id);

        return $model->belongsTo($this->getModelClassName($relation), null, null, $relation);
    }

    /**
     * @param $model
     * @param $id
     * @param $related
     *
     * @throws \Exception
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    private function getBelongToManyRelation($model, $id, $related)
    {
        $model = $this->getModelInstance($model, $id);

        return $model->belongsToMany($this->getModelClassName($related));
    }

    /**
     * @param $model
     * @param $id
     * @param $related
     * @param $relatedId
     *
     * @throws \Exception
     */
    public function associate($model, $id, $related, $relatedId)
    {
        $this->getBelongToRelation($model, $id, $related)->associate($relatedId)->save();
    }

    /**
     * @param $model
     * @param $id
     * @param $related
     *
     * @throws \Exception
     */
    public function dissociate($model, $id, $related)
    {
        $this->getBelongToRelation($model, $id, $related)->dissociate()->save();
    }

    /**
     * @param $model
     * @param $id
     * @param $related
     * @param $relatedId
     *
     * @throws \Exception
     */
    public function attach($model, $id, $related, $relatedId)
    {
        $this->getBelongToManyRelation($model, $id, $related)->syncWithoutDetaching($relatedId);
    }

    /**
     * @param $model
     * @param $id
     * @param $related
     * @param $relatedId
     *
     * @throws \Exception
     */
    public function detach($model, $id, $related, $relatedId)
    {
        $this->getBelongToManyRelation($model, $id, $related)->detach($relatedId);
    }
}
