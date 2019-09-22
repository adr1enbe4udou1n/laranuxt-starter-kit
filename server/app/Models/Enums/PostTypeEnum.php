<?php

namespace App\Models\Enums;

use Spatie\Enum\Enum;

/**
 * Class PostTypeEnum.
 *
 * @method static self post()
 * @method static self page()
 */
final class PostTypeEnum extends Enum
{
    public function __toString(): string
    {
        return (string) __("enums.post_type_enum.{$this->value}");
    }
}
