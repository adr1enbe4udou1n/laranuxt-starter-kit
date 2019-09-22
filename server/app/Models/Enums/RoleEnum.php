<?php

namespace App\Models\Enums;

use Spatie\Enum\Enum;

/**
 * Class Role.
 *
 * @method static self admin()
 * @method static self editor()
 * @method static self author()
 */
class RoleEnum extends Enum
{
    public function __toString(): string
    {
        return (string) __("enums.role_enum.{$this->value}");
    }
}
