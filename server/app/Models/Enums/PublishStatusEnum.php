<?php

namespace App\Models\Enums;

use Spatie\Enum\Enum;

/**
 * Class PublishStatusEnum.
 *
 * @method static self draft()
 * @method static self scheduled()
 * @method static self published()
 */
final class PublishStatusEnum extends Enum
{
    public function __toString(): string
    {
        return (string) __("enums.publish_status_enum.{$this->value}");
    }
}
