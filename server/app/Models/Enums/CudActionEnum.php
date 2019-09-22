<?php

namespace App\Models\Enums;

use Spatie\Enum\Enum;

/**
 * Class CudAction.
 *
 * @method static self create()
 * @method static self update()
 * @method static self delete()
 */
final class CudActionEnum extends Enum
{
    public function __toString(): string
    {
        return (string) __("enums.cud_action_enum.{$this->value}");
    }
}
