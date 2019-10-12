<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Submission.
 *
 * @property int                             $id
 * @property mixed                           $data
 * @property \Illuminate\Support\Carbon|null $created_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Submission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Submission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Submission query()
 * @mixin \Eloquent
 */
class Submission extends Model
{
    const UPDATED_AT = null;

    protected $fillable = ['data'];

    protected $casts = [
        'data' => 'array',
    ];
}
