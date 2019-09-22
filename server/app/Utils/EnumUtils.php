<?php

namespace App\Utils;

use Spatie\Enum\Enum;
use Illuminate\Support\Str;

/**
 * Class Enum.
 */
class EnumUtils
{
    /**
     * @param string|Enum $enum
     *
     * @throws \ReflectionException
     *
     * @return array
     */
    public static function toList($enum)
    {
        $name = Str::snake((new \ReflectionClass($enum))->getShortName());

        return collect($enum::getValues())->keyBy(static function ($item) {
            return $item;
        })->map(static function ($item) use ($name) {
            return __("enums.$name.$item");
        })->toArray();
    }

    /**
     * Retourne tous les enums.
     *
     * @throws \ReflectionException
     *
     * @return array
     */
    public static function all()
    {
        $enums = [];

        foreach (glob(app_path().'/Models/Enums/*.php') as $classPath) {
            $classname = pathinfo($classPath, PATHINFO_FILENAME);
            $enum = "App\\Models\\Enums\\$classname";
            $enums[Str::snake($classname)] = static::toList($enum);
        }

        return $enums;
    }
}
