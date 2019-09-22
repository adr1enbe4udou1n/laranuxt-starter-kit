<?php

namespace App\Models\Contracts;

interface BulkActions
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public static function bulkList();
}
