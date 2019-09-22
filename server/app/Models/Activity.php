<?php

namespace App\Models;

use App\Models\Traits\HasUser;
use App\Models\Enums\CudActionEnum;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Activity.
 *
 * @property int                                           $id
 * @property int|null                                      $user_id
 * @property string                                        $model_type
 * @property int                                           $model_id
 * @property string                                        $action
 * @property array|null                                    $old_data
 * @property \Illuminate\Support\Carbon|null               $created_at
 * @property mixed                                         $action_badge
 * @property mixed                                         $action_enum
 * @property mixed                                         $action_label
 * @property mixed                                         $model_label
 * @property mixed                                         $model_name
 * @property \Illuminate\Database\Eloquent\Model|\Eloquent $model
 * @property \App\Models\User|null                         $user
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Activity newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Activity newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Activity query()
 * @mixin \Eloquent
 */
class Activity extends Model
{
    use HasUser;

    const UPDATED_AT = null;

    protected $casts = [
        'old_data' => 'array',
    ];

    protected $appends = [
        'action_label',
        'action_badge',
        'model_name',
        'model_label',
    ];

    protected $with = [
        'model',
    ];

    public function getActionEnumAttribute()
    {
        return CudActionEnum::make($this->action);
    }

    public function getActionLabelAttribute()
    {
        return (string) $this->action_enum;
    }

    public function getActionBadgeAttribute()
    {
        switch ($this->action) {
            case 'create':
                return 'success';
            case 'update':
                return 'warning';
            case 'delete':
                return 'danger';
        }

        return 'info';
    }

    public function getModelNameAttribute()
    {
        return __("crud.models.{$this->model_type}");
    }

    public function getModelLabelAttribute()
    {
        return $this->model ? $this->model->__toString() : null;
    }

    public function model()
    {
        return $this->morphTo();
    }
}
